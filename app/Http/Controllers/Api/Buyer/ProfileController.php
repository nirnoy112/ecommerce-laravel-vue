<?php

namespace App\Http\Controllers\Api\Buyer;

use DB;
use Uuid;
use App\Model\User;
use App\Model\Order;
use App\Model\State;
use App\Model\Review;
use App\Model\Country;
use App\Model\Setting;
use Validator;
use App\Model\Size;
use App\Model\ItemImages;
use App\Model\Color;
use App\Model\MetaBuyer; 
use App\Model\MetaVendor;
use App\Model\AdminMessage;
use App\Model\BuyerMessage;
use App\Model\WishListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enumeration\OrderStatus;
use App\Model\BuyerAddress;
use App\Model\Newsletter;
use App\Enumeration\VendorImageType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{  
    public function index(){
        $user = Auth::user();
        $user->load('buyer'); 
        $defaultBilling = BuyerAddress::with('state', 'country')
                                ->where('user_id', Auth::user()->id)
                                ->where('set_default', 'LIKE', '%billing%')
                                ->first();
        $defaultShipping = BuyerAddress::with('state', 'country')
                                ->where('user_id', Auth::user()->id)
                                ->where('set_default', 'LIKE', '%shipping%')
                                ->first();
        $newsletter = Newsletter::where('email', Auth::user()->email)
                                ->first();
        return response()->json(['user' => $user, 'defaultBilling'=> $defaultBilling, 'defaultShipping'=> $defaultShipping, 'newsletter' => $newsletter], 200);
    }
    public function address(Request $request) {
        $user = Auth::user();
        $user->load('buyer'); 
        $metabuyer = MetaBuyer::where('id', Auth::user()->buyer_meta_id)->with('user')->first(); 
        $usStates = State::where('country_id', 1)->orderBy('name')->get()->toArray();
        if ($request->manage && $request->manage == 'customer'){
            $addresses = BuyerAddress::where('user_id', Auth::user()->id) ->with('state', 'country')->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $addresses['data'] = BuyerAddress::where('user_id', Auth::user()->id) ->with('state', 'country')->orderBy('updated_at', 'desc')->get();
        }
        return response()->json(['user' => $user,'metabuyer'=> $metabuyer,'usStates'=> $usStates,'addresses'=> $addresses], 200);
    }
    public function removeAddress(Request $request){
        $request->validate([
            'address_id' => 'required|exists:buyer_addresses,id', 
        ]);
        
        $address = BuyerAddress::where('user_id', $request->user()->id)
                                ->where('id', $request->address_id)
                                ->first();

        if ($address) {
            $address->delete();
        }

        return response()->json(['message' => 'Your request is successfull.'], 200);
    }
    public function defaultAddress(Request $request){
        // on set default address. change it also from meta buyer
        $request->validate([
            'address_id' => 'required|exists:buyer_addresses,id', 
            'set_default' => 'required|in:billing,shipping', 
        ]);
        $set_default = $request->set_default;
        switch ($set_default) {
            case 'billing':
                $defaultBillings = BuyerAddress::where('user_id', $request->user()->id)
                                    ->where('set_default', 'LIKE', '%billing%')
                                    ->get();
                foreach ($defaultBillings as $defaultBilling) {
                    $old_default = $defaultBilling->set_default;
                    $new_default = $old_default;
                    if (strpos($old_default, 'billing') !== false) {
                        $new_default = str_replace("billing", "", $old_default);
                    }
                    $defaultBilling->set_default = $new_default;
                    $defaultBilling->save();
                }
                
                $billingAddress = BuyerAddress::where('user_id', $request->user()->id)
                                    ->where('id', $request->address_id)
                                    ->first();
                $billingAddress->set_default = $billingAddress->set_default.',billing';
                $billingAddress->save();
                break;
            case 'shipping':
                $defaultShippings = BuyerAddress::where('user_id', $request->user()->id)
                                    ->where('set_default', 'LIKE', '%shipping%')
                                    ->get();
                foreach ($defaultShippings as $defaultShipping) {
                    $old_default = $defaultShipping->set_default;
                    $new_default = $old_default;
                    if (strpos($old_default, 'shipping') !== false) {
                        $new_default = str_replace("shipping", "", $old_default);
                    }
                    $defaultShipping->set_default = $new_default;
                    $defaultShipping->save();
                }
                $shippingAddress = BuyerAddress::where('user_id', $request->user()->id)
                                    ->where('id', $request->address_id)
                                    ->first();
                $shippingAddress->set_default = $shippingAddress->set_default.',shipping';
                $shippingAddress->save();
                break;
        }
        return response()->json(['message' => 'Your request is successfull.'], 200);
    }
    public function addAddress(Request $request){  
        $request->validate([
            'first_name' => 'required|string', 
            'last_name' => 'nullable|string', 
            'store_no' => 'nullable|string', 
            'address' => 'required|string', 
            'address2' => 'nullable|string', 
            'city' => 'required|string', 
            'phone' => 'required|string', 
            'zip' => 'required|string', 
            'fax' => 'nullable|string', 
            'location' => 'required|string', 
            'id' => 'nullable|numeric|exists:buyer_addresses,id', 
            'state_id' => 'nullable|numeric|exists:states,id', 
            'country_id' => 'required|numeric|exists:countries,id', 
            'set_default' => 'nullable|string|in:billing,shipping', 
        ]);
        // $rules['address']= 'required';
        // $rules['city']= 'required';
        // $rules['state_text']= 'required_without_all:state_id' ; 
        // $rules['state_id']= 'required_without_all:state_text' ;
        // $rules['zip']= 'required';
        // $rules['country_id']= 'required';
        // $rules['phone']= 'required';  
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     return response()->json(['error'=>$validator->messages()], 200); 
        // }

        $state_id = null;
        $state = null; 
        if ($request->location == "INT")
            $state = $request->state_text;
        else
            $state_id = $request->state_id; 
        
        $address = BuyerAddress::create([
            'user_id' => $request->user()->id, 
            'location' => $request->address2,
            'address' => $request->address, 
            'city' => $request->city,
            'state_id' => $state_id,
            'state_text' => $state,
            'zip' => $request->zip,
            'country_id' => $request->country_id,
            'phone' => $request->phone,  
        ]);

        return response()->json(['result' => 'success'], 200);
    }
    public function updateAddress(Request $request){ 
            $request->validate([
                'first_name' => 'required|string', 
                'last_name' => 'nullable|string', 
                'store_no' => 'nullable|string', 
                'address' => 'required|string', 
                'address2' => 'nullable|string', 
                'city' => 'required|string', 
                'phone' => 'required|string', 
                'zip' => 'required|string', 
                'fax' => 'nullable|string', 
                'location' => 'required|string', 
                'id' => 'nullable|numeric|exists:buyer_addresses,id', 
                'state_id' => 'nullable|numeric|exists:states,id', 
                'country_id' => 'required|numeric|exists:countries,id', 
                'set_default' => 'nullable|string|in:billing,shipping', 
            ]);
            // $rules['address']= 'required';
            // $rules['city']= 'required';
            // $rules['state_text']= 'required_without_all:state_id' ; 
            // $rules['state_id']= 'required_without_all:state_text' ;
            // $rules['zip']= 'required';
            // $rules['country_id']= 'required';
            // $rules['phone']= 'required';  
            // $validator = Validator::make($request->all(), $rules);
            // if ($validator->fails()) {
            //     return response()->json(['error'=>$validator->messages()], 200); 
            // }
        $state_id = null;
        $state = null;
        if ($request->location == "INT")
            $state = $request->state_text;
        else
            $state_id = $request->state_id;

        $BuyerAddress = BuyerAddress::where('id', $request->id)->first();
        if($BuyerAddress) {
            $BuyerAddress->update([ 
                'location' => $request->address2,
                'address' => $request->address, 
                'city' => $request->city,
                'state_id' => $state_id,
                'state_text' => $state,
                'zip' => $request->zip,
                'country_id' => $request->country_id,
                'phone' => $request->phone,  
            ]);
        }
        return response()->json(['result' => 'success'], 200);
    }
    public function orders(Request $request){
        $unread_messages = 0;
        if(Auth::user()){
            $unread_messages = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        $orders = Order::where('status', '!=', OrderStatus::$INIT)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);  
        return response()->json(['orders' => $orders, 'unread_messages'=> $unread_messages], 200);
    }
    public function OrderDetails($id){ 
        $order = Order::find($id); 
        $allItems = [];
        $order->load( 'items'); 
        $vendor = MetaVendor::where('id', 1)->first();
        $order->vendor = $vendor; 
        // Logo
        $default_img = Setting::where('name', 'default-item-image')->first(); 
        $vendor_logo_path = ''; 
        $black = \DB::table('settings')->where('name', 'logo-black')->first();
        if ($black)
            $vendor_logo_path = asset($black->value);
        $i = 0;
        foreach($order->items as $item){
            $id = $item->item_id;
            if(!empty($item->color)){ 
                $item->image = ItemImages::where('item_id',$id)->where('color_id',$item->color)->first(); 
            }else{ 
                $item->image = ItemImages::where('item_id',$id)->first(); 
            }
            $allItems[$i] = $item; 
            if(!empty($item->size)){ 
                $allItems[$i]['sizes'] = Size::where('id',$item->size)->first();  
            }else{
                $allItems[$i]['sizes'] = '';  

            }
            if(!empty($item->color)){ 
                $allItems[$i]['colors'] = Color::where('id',$item->color)->first();  
            }else{
                $allItems[$i]['colors'] = '';  

            }
            $i++;
        }

        return response()->json(['orders' => $order, 'allItems'=> $allItems,'default_img' =>$default_img, 'vendor_logo_path' => $vendor_logo_path], 200);
    }
    public function billingaddresspost(Request $request){
        $rules['factoryAddress']= 'required';
        $rules['factoryCity']= 'required';
        $rules['factoryState']= 'required_without_all:factoryStateSelect' ; 
        $rules['factoryStateSelect']= 'required_without_all:factoryState' ;
        $rules['factoryZipCode']= 'required';
        $rules['factoryCountry']= 'required';
        $rules['factoryPhone']= 'required';  
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->messages()], 200); 
        }  
        $buyer = MetaBuyer::where('id', Auth::user()->buyer_meta_id)->first();
        $factory_state_id = null;
        $factory_state = null; 
        if ($request->factoryLocation == "INT")
            $factory_state = $request->factoryState;
        else
            $factory_state_id = $request->factoryStateSelect; 
        
        $buyer->billing_location = $request->factoryLocation;
        $buyer->billing_address = $request->factoryAddress; 
        $buyer->billing_city = $request->factoryCity;
        $buyer->billing_state_id = $factory_state_id;
        $buyer->billing_state = $factory_state;
        $buyer->billing_zip = $request->factoryZipCode;
        $buyer->billing_country_id = $request->factoryCountry;
        $buyer->billing_phone = $request->factoryPhone;  

        $buyer->save();
        return response()->json([], 200);
    }

    public function deleteShippingAddress(Request $request) { 
        if(BuyerAddress::where('id', $request[0])->delete()){
            return response()->json(['message'=>'success'], 200);
        }else{
            return response()->json(['message'=>'faile'], 200);
        }
    }
}
