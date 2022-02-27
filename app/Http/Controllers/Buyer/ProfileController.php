<?php

namespace App\Http\Controllers\Buyer;

use DB;
use Uuid;
use App\Model\User;
use App\Model\Order;
use App\Model\State;
use App\Model\Review;
use App\Model\Country;
use App\Model\Setting;
use App\Model\MetaBuyer;
use App\Model\MetaVendor;
use App\Model\AdminMessage;
use App\Model\BuyerMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enumeration\OrderStatus;
use App\Model\BuyerShippingAddress;
use App\Enumeration\VendorImageType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    public function buyerDashboard(){
        $user = Auth::user();
        $buyer_home = '';
        $setting = Setting::where('name', 'buyer_home')->first();
        if ($setting)
            $buyer_home = $setting->value;

        $orders = $orders = Order::where('status', '!=', OrderStatus::$INIT)
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')->limit(4)->get();
            
        if(Auth::user()){
            $unread_messages = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        return view('buyer.profile.buyer_dashboard',compact('user', 'buyer_home', 'orders','unread_messages'));
    }

    public function shippingInfo()
    {
        if(Auth::user()){
            $data['unread_messages'] = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        $data['user'] = Auth::user();
        $data['countries'] = Country::orderBy('name')->get();
        $data['states'] = State::orderBy('name')->get();
        $data['editShippingInfo'] = BuyerShippingAddress::with('state', 'country')->where('user_id', auth()->user()->id)->first();
        $data['buyerAvatar'] = MetaBuyer::where('user_id', auth()->user()->id)->first();
        
        
        return view('buyer.profile.buyer_shipping_info',$data);
    }

    public function updateShippingInfo(Request $request)
    {
        $rules  = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'phone' => 'required',
        ];
        $request->validate($rules);

        $user = Auth::user();
        $user->load('buyerShipping');

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->buyerShipping->address = $request->address;
        $user->buyerShipping->city = $request->city;
        $user->buyerShipping->state_text = $request->state_text;
        $user->buyerShipping->state_id = $request->state;
        $user->buyerShipping->zip = $request->zip;
        $user->buyerShipping->country_id = $request->country;
        $user->buyerShipping->phone = $request->phone;
        $user->save();
        $user->buyerShipping->save();

        return redirect()->back()->with('flash_message_success', 'Profile Updated Successfully.');
    }
    public function updateProfile(Request $request) { 
        $rules  = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255', 
        ]; 

        if ($request->password != '')
            $rules['password'] = 'string|min:6|confirmed';

        $request->validate($rules);

        $user = Auth::user();
        $user->load('buyer');

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->buyer->company_name = $request->company_name;

        if ($request->password != '')
            $user->password = Hash::make($request->password);

        $user->save();
        $user->buyer->save();

        return redirect()->back()->with('message', 'Profile Updated!');
    }
    public function buyerBilling()
    {
        if(Auth::user()){
            $data['unread_messages'] = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        $data['title'] = "Buyer Billing Information Update";
        $data['countries'] = Country::orderBy('name')->get();
        $data['states'] = State::orderBy('name')->get();

        $data['buyerBillingInfo'] = MetaBuyer::where('user_id', auth()->user()->id)->first();
        $data['buyerAvatar'] = MetaBuyer::where('user_id', auth()->user()->id)->first();
        return view('buyer.profile.billing', $data);
    }

    public function editBillingAddress(Request $request)
    {
        $rules  = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'phone' => 'required',

        ];
        $request->validate($rules);

        $buyer = Auth::user();
        $buyer->first_name = $request->first_name;
        $buyer->last_name = $request->last_name;
        $buyer->save();

        $buyer = MetaBuyer::where('id', Auth::user()->buyer_meta_id)->first();
        $buyer->billing_address = $request->address;
        $buyer->billing_city = $request->city;
        $buyer->billing_state = $request->state_text;
        $buyer->shipping_state_id = $request->state;
        $buyer->billing_zip = $request->zip;
        $buyer->billing_country_id = $request->country;
        $buyer->billing_phone = $request->phone;
        $buyer->billing_state_id = $request->state;
        $buyer->save();

        return redirect()->back()->with('flash_message_success', 'Billing Information Updated!');
    }

    public function orders()
    {
        if(Auth::user()){
            $unread_messages = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        $orders = Order::where('status', '!=', OrderStatus::$INIT)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $data['buyerAvatar'] = MetaBuyer::where('user_id', auth()->user()->id)->first();
        return view('buyer.profile.orders', compact('orders','unread_messages'),$data)->with('page_title', 'My Orders');
    }
    
    public function message()
    {
        $messages = BuyerMessage::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        if(Auth::user()){
            $unread_messages = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }

    return view('buyer.profile.messages', compact('messages','unread_messages'))->with('profile_page', 'My All Messages');
    }

    public function message_unread_count(Request $request)
    {
        BuyerMessage::where('id', $request->id)
            ->update(['reading_status' => 1]);
    }

    public function send_message_admin(Request $request)
    {
        if(!empty($request->file('attachment1'))){
            $attachment1 = $this->attachmentUpload($request->file('attachment1'));
        }

        if(!empty($request->file('attachment2'))){
            $attachment2 = $this->attachmentUpload($request->file('attachment2'));
        }

        if(!empty($request->file('attachment3'))){
            $attachment3 = $this->attachmentUpload($request->file('attachment3'));
        }

        AdminMessage::create([
            'user_id' => $request->message_user_id,
            'sender' => $request->message_sender,
            'recipient' => $request->message_recipient,
            'subject' => $request->message_subject,
            'message' => $request->message,
            'attachment1' => $attachment1 ?? '',
            'attachment2' => $attachment2 ?? '',
            'attachment3' => $attachment3 ?? '',
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        $request->session()->flash('message', 'Message Send To '.$request->message_recipient);
        return  Redirect::back();
    }

    public function attachmentUpload( $attachment = null)
    {
        $filename = Uuid::generate()->string;
        $file = $attachment;
        $ext = $file->getClientOriginalExtension();

        $destinationPath = '/buyer_message_attachment';
        $file->move(public_path($destinationPath), $filename.".".$ext);
        $imagePath = $filename.".".$ext;

        return $imagePath;
    }

    public function addShippingAddress(Request $request) {
        $state_id = null;
        $state = null;

        if ($request->location == "INT")
            $state = $request->state;
        else
            $state_id = $request->stateSelect;

        $address = BuyerShippingAddress::create([
            'user_id' => Auth::user()->id,
            'store_no' => $request->store_no,
            'location' => $request->location,
            'address' => $request->address,
            'unit' => $request->unit,
            'city' => $request->city,
            'state_id' => $state_id,
            'state_text' => $state,
            'zip' => $request->zipCode,
            'country_id' => $request->country,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'commercial' => ($request->showroomCommercial == null) ? 0 : 1,
        ]);

        return response()->json($address->toArray());
    }
}
