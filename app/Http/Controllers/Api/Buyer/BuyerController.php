<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\MetaBuyer;
use App\Enumeration\PageEnumeration;
use App\Enumeration\Role;
use App\Model\Page;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\CartItem;
use App\Model\CartCoupon;
use App\Model\ItemInv;
use App\Model\MetaVendor;
use App\Enumeration\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use CreditCard;
use Validator;
use Mail;
use PDF;
use Log;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class BuyerController extends Controller
{
    /**
     * Create a new BuyerController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['checkout']);
    }
    /**
     * Get a JWT via given credentials. (Register)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUpdate(Request $request){ 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;    
        $user->email = $request->email;
        $user->save();
    }
    public function changePassword(Request $request){
        $request->validate([ 
            'current_password' => 'required' ,
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation', 
        ]);

        $user = Auth::user();  
        if (!$user){
            return response()->json(['message' => 'User Not Found'], 200);
        } else{   
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['errors' => ['current_password' => ['Old Password Not Metch.','status'=>'failed']]], 422);  
            }else{
                $user->password = Hash::make($request->password);
                $user->reset_token = $request->token;
                $user->save();
                return response()->json(['message' => 'Password Updated Successfully.','status'=>'success'], 200); 
            } 
        } 
    }
    public function checkout(Request $request) {
        $rules['userInput'] = "required|array";
        $rules['userInput.first_name'] = "required|string";
        $rules['userInput.last_name'] = "required|string";
        $rules['userInput.email'] = "required|email";

        $rules['billingInput'] = "required|array";
        $rules['billingInput.address'] = "required|string";
        $rules['billingInput.country_id'] = "required|exists:countries,id";
        $rules['billingInput.state_id'] = "nullable|exists:states,id";
        $rules['billingInput.zip'] = "required";

        $rules['shippingInput'] = "required|array";
        $rules['shippingInput.address'] = "required|string";
        $rules['shippingInput.country_id'] = "required|exists:countries,id";
        $rules['shippingInput.state_id'] = "nullable|exists:states,id";
        $rules['shippingInput.zip'] = "required";
        
        $rules['shippingMethod'] = "required|array";
        $rules['shippingMethod.id'] = "required|exists:admin_ship_methods,id";
        $rules['shippingMethod.fee'] = "nullable|numeric";
        $rules['shippingMethod.name'] = "required|string";
        
        $rules['paymentMethod'] = 'required|integer|min:1|max:3';
        $rules['note'] = 'nullable|string';
        $rules['user_point'] = 'nullable|numeric|min:0';

        if ($request->paymentMethod == '2') {
            $rules['cardInput'] = "required|array";
            $rules['cardInput.card_number'] = 'required|max:191|min:6';
            $rules['cardInput.card_full_name'] = 'required|max:191';
            $rules['cardInput.card_expire'] = 'required|date_format:"m/y"';
            $rules['cardInput.card_cvc'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules); 
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->messages()], 422); 
        }

        // card validation
        if ($request->paymentMethod == '2') {
            $validator->after(function ($validator) use($request) {
                // Card Number Check
                $card = CreditCard::validCreditCard($request['cardInput']['card_number']);

                if (!$card['valid'])
                    $validator->errors()->add('cardInput.card_number', 'Invalid Card Number');

                // CVC Check
                $validCvc = CreditCard::validCvc($request['cardInput']['card_cvc'], $card['type']);
                if (!$validCvc)
                    $validator->errors()->add('cardInput.card_cvc', 'Invalid CVC');

                // Expiry Check
                $tmp  = explode('/', $request['cardInput']['card_expire']);
                $validDate = CreditCard::validDate('20'.$tmp[1], $tmp[0]);
                if (!$validDate)
                    $validator->errors()->add('cardInput.card_expire', 'Invalid Expiry');
            });

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->messages()], 422); 
            }
        }

        // point validation
        if ($request->user_point) {
            $validator->after(function ($validator) use($request) {
                $user = $request->user();
                $user->load('buyer');
                if(!$user || !$user->buyer) {
                    $validator->errors()->add('user_point', 'Invalid Request');
                }
                if($user->buyer->points - $user->buyer->points_spent < $request->user_point) {
                    $validator->errors()->add('user_point', 'Do not have sufficient point.');
                }
            });
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->messages()], 422); 
            }
        }
        
        DB::beginTransaction();
        try {
            $user = $this->guard()->user();

            $orderData = [
                'status' => OrderStatus::$NEW_ORDER,
                'note' =>  $request['note'],
                'user_id' => $user ? $user->id : 0,
                'company_name' => ($user && $user->buyer) ? $user->buyer->company_name : '',
                'name' => $request['userInput']['first_name'].' '.$request['userInput']['last_name'], 
                'email' => $request['userInput']['email'],
                'can_call' => 0,

                'billing_location' => $request['billingInput']['address'],
                'billing_address' => $request['billingInput']['address2'],
                'billing_unit' => $request['billingInput']['unit'] ?? null,
                'billing_city' => $request['billingInput']['city'],
                'billing_state' => isset($request['billingInput']['state']) ? $request['billingInput']['state']['name'] : null,
                'billing_state_id' => $request['billingInput']['state_id'],
                'billing_state_text' => isset($request['billingInput']['state']) ? $request['billingInput']['state']['name'] : null,
                'billing_zip' => $request['billingInput']['zip'],
                'billing_country' => isset($request['billingInput']['country']) ? $request['billingInput']['country']['name'] : null,
                'billing_country_id' => $request['billingInput']['country_id'],
                'billing_phone' => $request['billingInput']['phone'],
                
                'shipping_location' => $request['shippingInput']['address'],
                'shipping_address' => $request['shippingInput']['address2'],
                'shipping_unit' => $request['shippingInput']['unit'] ?? null,
                'shipping_city' => $request['shippingInput']['city'],
                'shipping_state' => isset($request['shippingInput']['state']) ? $request['shippingInput']['state']['name'] : null,
                'shipping_state_id' => $request['shippingInput']['state_id'],
                'shipping_state_text' => isset($request['shippingInput']['state']) ? $request['shippingInput']['state']['name'] : null,
                'shipping_zip' => $request['shippingInput']['zip'],
                'shipping_country' => isset($request['shippingInput']['country']) ? $request['shippingInput']['country']['name'] : null,
                'shipping_country_id' => $request['shippingInput']['country_id'],
                'shipping_phone' => $request['shippingInput']['phone'],
            ];

            if ($request->paymentMethod == '2') {
                $orderData['card_number'] = encrypt($request['cardInput']['card_number']);
                $orderData['card_full_name'] = encrypt($request['cardInput']['card_full_name']);
                $orderData['card_expire'] = encrypt($request['cardInput']['card_expire']);
                $orderData['card_cvc'] = encrypt($request['cardInput']['card_cvc']);
                
                $orderData['payment_type'] = 'Credit Card';
                $card = CreditCard::validCreditCard($request->number);
                $orderData['payment_type'] = $card['type'];
            } else if ($request->paymentMethod == '1') {
                $orderData['payment_type'] = 'Wire Transfer';
            } else if ($request->paymentMethod == '3') {
                $orderData['payment_type'] = 'PayPal';
            }
            
            $orderData['shipping_method_id'] = $request['shippingMethod']['id'];
            $orderData['shipping'] = $request['shippingMethod']['name'];
            $orderData['shipping_cost'] = $request['shippingMethod']['fee'];

            

            $order = Order::create($orderData); 

            // Cart Items
            $user_id = $this->guard()->id();
            $user_ip = $request->ip();
            if(!$user_id) {
                $userArray = [$user_ip];
            } else {
                $userArray = [$user_id, $user_ip];
            }
            $cartItems = CartItem::with('item')->whereIn('user_id', $userArray)->get();  
            $subTotal = 0;
                
            foreach ($cartItems as $cartItem) {  
                $subTotal += number_format($cartItem->quantity *  $cartItem->item->price, 2, '.',''); 
                OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $cartItem->item_id,
                        'style_no' => $cartItem->item->style_no,
                        'color' => $cartItem->color_id,
                        'size' => $cartItem->size_id,  
                        'qty' => $cartItem->quantity,
                        'total_qty' => $cartItem->quantity,
                        'per_unit_price' => $cartItem->item->price,
                        'amount' => number_format( $cartItem->item->price, 2, '.', ''),
                    ]);
            }

            $coupon = app('App\Http\Controllers\Api\CartController')->getCoupon($user_id, $userArray); 
            
            if (!$coupon) {
                $order->free_shipping = 0; 
                $order->subtotal = number_format($subTotal, 2, '.', '');
                $order->discount = 0.00;
                $order->promotion_details = '';
                $order->shipping_cost = $request['shippingMethod']['fee']; 
                $order->coupon = ''; 
                $order->free_shipping = 0; 
            } else {
                $order->free_shipping = $coupon->free_shipping; 
                $order->subtotal = number_format($subTotal, 2, '.', '');
                $order->discount = number_format($coupon->discount, 2, '.', '');
                $order->promotion_details = $coupon->promotion_details;
                $order->coupon = $coupon->coupon_code;
                if ($coupon->free_shipping == 1) {
                    $order->shipping_cost = 0.00; 
                } else {
                    $order->shipping_cost = $request['shippingMethod']['fee']; 
                }
            }
            $order->order_number = $this->generateRandomString(13);
            $order->total = number_format($subTotal - $order->discount, 2, '.', ''); 

            $order->save();

            //point system start
            $dollarDiscount = 0;
            if($request->user_point){
                $oldDollarSpentPoints = MetaBuyer::select('points_spent')->where('user_id',Auth::user()->id)->first();
                $finalSpent = $oldDollarSpentPoints->points_spent + $request->user_point;
                MetaBuyer::where('user_id',Auth::user()->id)->update(['points_spent' => $finalSpent]);

                $order->used_dollar_point = $request->user_point;

                $pointDollarDiscount = DB::table('point_dollar_discount')->first();
                $dollar_point_discount = ($pointDollarDiscount->dollar_disounts * $request->user_point) / $pointDollarDiscount->points_use;
                $order->dollar_point_discount = number_format($dollar_point_discount, 2, '.', '');
                $dollarDiscount = $dollar_point_discount;
            }
            
            $pointSetting = DB::table('point_system_settings')->where('status',1)->first();
            //calculate point for order
            if(!empty($pointSetting)){
                $total = ($order->subtotal - $order->discount - $dollarDiscount) + $request['shippingMethod']['fee'];
                $newPoints = number_format(($pointSetting->point_rewards * $total) / $pointSetting->cost_dollars, 2, '.', '');
                $oldPoints = MetaBuyer::select('points')->where('user_id',Auth::user()->id)->first();
                $oldPoints =  $oldPoints->points;
                $totalPoints = $oldPoints + $newPoints;

                $order->points = number_format($newPoints, 2, '.', '');
                MetaBuyer::where('user_id',Auth::user()->id)->update(['points'=> number_format($totalPoints, 2, '.', '')]);
                $order->total = number_format($total, 2, '.', '');;
            }
            $order->save();
            //point system end

            $cartItems = CartItem::whereIn('user_id', $userArray)->get();
            foreach ($cartItems as $cartItem) {
                $itemInventory = ItemInv::where('item_id', $cartItem->item_id)->where('color_id', $cartItem->color_id)->where('itemsize', $cartItem->size_id)->first();
                if(isset($itemInventory)){
                    ItemInv::where('item_id', $cartItem->item_id)->where('color_id', $cartItem->color_id)->where('itemsize', $cartItem->size_id)->update([
                        'qty' => $itemInventory->qty - $cartItem->quantity
                    ]);
                }
            }
            $cartItems = CartItem::whereIn('user_id', $userArray)->delete();
 
            $user = $this->guard()->user();
            if($user) {
                $user->increment('order_count');
            }

            // User Billing Information meta data update
            // $usermeta = MetaBuyer::where('user_id', $user_id)->first();
            // $usermeta->billing_location = $request['billingInput']['address'];
            // $usermeta->billing_address = $request['billingInput']['address2'];
            // $usermeta->billing_city = $request['billingInput']['city'];
            // $usermeta->billing_state_id = $request['billingInput']['state_id'];
            // $usermeta->billing_zip = $request['billingInput']['zip'] ;
            // $usermeta->billing_phone = $request['billingInput']['phone'];
            // $usermeta->billing_country_id = $request['billingInput']['coutry_id'];
            // $usermeta->billing_unit = $request['billingInput']['unit'];
            // $usermeta->billing_state = $request['billingInput']['state'] ? $request['billingInput']['state']['name'] : null;
            // $usermeta->save();
            
            // if($request->address_id !=null){ 
            //     $userShippingAddressD= BuyerShippingAddress::where('id',$request->address_id)->where('user_id',$user->id)->update(['default'=> 1]);
            //     $userShippingAddress= BuyerShippingAddress::where('id','<>',$request->address_id)->where('user_id',$user->id)->update(['default'=> 0]);
            // }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return response()->json(['success' => true, 'message' => 'Order Completed. And progresssing e-mail ', 'order_number' => $order->order_number], 200);
    }
    public function sendOrderEmail(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number', 
        ]);
        
        $order = Order::where('order_number', '=', $request->order_number)->first();
        $requestUserId = $this->guard()->id();
        if($order->user_id != $requestUserId) return ;

        $pdfData = $this->getPdfData($order);
        // Send Mail to Buyer
        $order_time = Carbon::parse($order->created_at)->format('F d ,Y h:i:s A ');
        $orderItem = OrderItem::where('order_id', $order->id)->count('item_id');
        Mail::send('emails.buyer.order_confirmation', ['order' => $order, 'order_time' => $order_time, 'order_item' => $orderItem], function ($message) use ($order, $pdfData) {
            $message->subject('Order Confirmed');
            $message->to($order->email, $order->name);
            $message->attachData($pdfData, $order->order_number . '.pdf');
        });

        // Send Mail to Vendor
        $user = User::where('role', Role::$EMPLOYEE)->first();
        if(!$user) return;
        Mail::send('emails.vendor.new_order', ['order' => $order, 'order_time' => $order_time], function ($message) use ($order, $pdfData, $user) {
            $message->subject('New Order - '.$order->order_number);
            $message->to($user->email, $user->first_name.' '.$user->last_name);
            $message->attachData($pdfData, $order->order_number.'.pdf');
        });
    }
    public function checkOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number', 
        ]);
        
        $order = Order::where('order_number', '=', $request->order_number)->first();
        $requestUserId = $this->guard()->id();
        if($order->user_id != $requestUserId) 
            return response()->json(['message'=> 'unauthenticated'], 403); 
        return response()->json(['message'=> 'yes and authenticate'], 200); 
    }
    public function singleOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number', 
        ]);
        
        $order = Order::where('order_number', '=', $request->order_number)->first();
        $requestUserId = $this->guard()->id();
        if($order->user_id != $requestUserId) 
            return response()->json(['message'=> 'unauthenticated'], 403); 
        $order->load('items', 'items.item', 'items.item.images');
        return response()->json(['message'=> 'yes and authenticate', 'order' => $order], 200); 
    }
    public function applyCoupon(Request $request) { 
        $request->validate([
            'coupon' => 'required|exists:promotions,coupon_code',
        ]);
        
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        } 
            
        $coupon = \App\Model\Promotion::where('coupon_code', strtoupper(trim($request->coupon)))->where('status', 1)->first();
        // coupon exist or not.
        if (!$coupon)
            return response()->json(['errors' => ['coupon' => ['Invalid Coupon.']]], 422);

        // coupon multiple used or not.
        if ($coupon->multiple_use == 0) {
            $previousOrder = Order::where('user_id', $user_id)
                ->where('status', '!=', OrderStatus::$INIT)
                ->where('coupon', $coupon->coupon_code)
                ->first();

            if ($previousOrder)
                return response()->json(['errors' => ['coupon' => ['Coupon code has already been used once.']]], 422);
        }

        // for permanent coupon check expirity
        if($coupon->is_permanent == 0) {
            $startDate = strtotime($coupon->valid_from);
            $endDate = strtotime($coupon->valid_to);

            $currentTime = time();

            if($currentTime > $startDate && $currentTime < $endDate) {
                // valid
            } else {
                // not valid
                return response()->json(['success' => false, 'message' => 'Coupon Expired.']);
            }
        }


        $data = app('App\Http\Controllers\Api\CartController')->cartCouponDiscount($coupon, $user);
        $data['coupon_code'] = $coupon->coupon_code;
        $data['user_id'] = $user_id;
        $oldCartCoupon = CartCoupon::where('user_id', $user_id)
            ->first(); 

        if ($oldCartCoupon) {
            // make logic for which one to take.
            $oldCartCoupon->update($data);
        } else {
            $cartCoupon = CartCoupon::create($data);
        }
        return response()->json(['success' => true, 'message' => 'Success.', 'coupon' => $data]);
    }
    public function removeCoupon(Request $request) {  
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        } 

        $oldCartCoupon = CartCoupon::where('user_id', $user_id)
            ->first(); 

        if ($oldCartCoupon) {
            // remove if coupon exist
            $oldCartCoupon->delete();
        }
        return response()->json(['success' => true, 'message' => 'Success.']);
    }
    
    public function getPdfData($order) {
        $allItems = [];
        $order->load('user', 'items');

        // Decrypt
        $cardNumber = '';
        $cardFullName = '';
        $cardExpire = '';
        $cardCvc = '';

        try {
            $cardNumber = decrypt($order->card_number);
            $cardFullName = decrypt($order->card_full_name);
            $cardExpire = decrypt($order->card_expire);
            $cardCvc = decrypt($order->card_cvc);
        } catch (DecryptException $e) {

        }

        $order->card_number = $cardNumber;
        $order->card_full_name = $cardFullName;
        $order->card_expire = $cardExpire;
        $order->card_cvc = $cardCvc;

        foreach($order->items as $item)
            $allItems[$item->item_id][] = $item;

        $logo_path = '';

        $vendor = MetaVendor::where('id', 1)->first();
        $order->vendor = $vendor;

        $black = DB::table('settings')->where('name', 'logo-black')->first();
            if ($black)
                $logo_path = public_path($black->value);

        $page = Page::where('page_id', PageEnumeration::$PRIVACY_POLICY)->first();
        if ($page) {
            $content = $page->content;
        }else {
            $content = '';
        }

        $data = [
            'all_items' => [$allItems],
            'orders' => [$order],
            'logo_paths' => [$logo_path],
            'privacy_policy' => $content
        ];

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admin.dashboard.orders.pdf.with_image', $data);
        return $pdf->output();
    }
    public function guard(){
        return Auth::Guard('api');
    }
    public function generateRandomString($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}