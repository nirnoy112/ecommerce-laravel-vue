<?php

namespace App\Http\Controllers\Buyer;

use App\Enumeration\OrderStatus;
use App\Model\AdminShipMethod;
use App\Model\AuthorizeLog;
use App\Model\BuyerShippingAddress;
use App\Model\CartItem;
use App\Model\Country;
use App\Model\MetaVendor;
use App\Model\Order;
use App\Model\ItemInv;
use App\Model\OrderItem;
use App\Model\Page;
use App\Enumeration\PageEnumeration;
use App\Model\Promotion;
use App\Model\State;
use Illuminate\Http\Request;
use App\Model\StoreCredit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use CreditCard;
use Illuminate\Support\Facades\DB;
use Validator;
use Mail;
use PDF;
use Carbon\Carbon;

// For Authorize Checkout
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Log;

class CheckoutController extends Controller
{
    public function create(Request $request) {
        $user = Auth::user();
        $user->load('buyer');

        $meta_vendor = MetaVendor::where('verified', 1)->where('active', 1)->get()->first();
        $minimum_order_amount = ( isset($meta_vendor->min_order) && $meta_vendor->min_order != '' ) ? $meta_vendor->min_order : 0;

        $storeCredit = 0;

         if ($request->storeCredit && is_numeric($request->storeCredit)) {
             $sc = StoreCredit::where('user_id', Auth::user()->id)->first();

             if (!$sc) {
                 return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
             }

             if ($sc->amount < $request->storeCredit)
                 return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
             else
                 $storeCredit = (float) $request->storeCredit;
         }

        $order = Order::create([
            'status' => OrderStatus::$INIT,
            'user_id' => $user->id,
            'name' => $user->first_name.' '.$user->last_name,
            'company_name' => $user->buyer->company_name,
            'email' => $user->email,
            'billing_location' => $user->buyer->billing_location,
            'billing_address' => $user->buyer->billing_address,
            'billing_unit' => $user->buyer->billing_unit,
            'billing_city' => $user->buyer->billing_city,
            'billing_state' => ($user->buyer->billingState == null) ? $user->buyer->billing_state : $user->buyer->billingState->code,
            'billing_state_id' => $user->buyer->billing_state_id,
            'billing_state_text' => $user->buyer->billing_state,
            'billing_zip' => $user->buyer->billing_zip,
            'billing_country' => $user->buyer->billingCountry->name,
            'billing_country_id' => $user->buyer->billing_country_id,
            'billing_phone' => $user->buyer->billing_phone,
        ]); 

        // calculate total amount
        $cartItems = CartItem::where('user_id', $order->user_id)->get();
        $subTotal = 0;
        foreach ($cartItems as $cartItem) {
            $sizes = explode("-", $cartItem->item->pack->name);
            $pack = '';
            $itemInPack = 0;

            for ($i = 1; $i <= sizeof($sizes); $i++) {
                $var = 'pack' . $i;

                if ($cartItem->item->pack->$var != null) {
                    $pack .= $cartItem->item->pack->$var . '-';
                    $itemInPack += (int)$cartItem->item->pack->$var;
                } else {
                    $pack .= '0-';
                }
            }

            $subTotal += $itemInPack * $cartItem->quantity * $cartItem->item->price;
        }

        if ( $minimum_order_amount > $subTotal ) {
            return response()->json(['success' => false, 'message' => 'Minimum order amount is : ' . $minimum_order_amount]);
        }

        // Cart Items
        $cartItems = CartItem::where('user_id', $order->user_id)->get();
        
        $subTotal = 0;

        foreach ($cartItems as $cartItem) {
            $sizes = explode("-", $cartItem->item->pack->name);
            $pack = '';

            $itemInPack = 0;

            for ($i = 1; $i <= sizeof($sizes); $i++) {
                $var = 'pack' . $i;

                if ($cartItem->item->pack->$var != null) {
                    $pack .= $cartItem->item->pack->$var . '-';
                    $itemInPack += (int)$cartItem->item->pack->$var;
                } else {
                    $pack .= '0-';
                }
            }

            $pack = rtrim($pack, "-");
            $subTotal += number_format($itemInPack * $cartItem->quantity * $cartItem->item->price, 2, '.', '');

            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'style_no' => $cartItem->item->style_no,
                'color' => $cartItem->color->name,
                'size' => $cartItem->item->pack->name,
                'item_per_pack' => $itemInPack,
                'pack' => $pack,
                'qty' => $cartItem->quantity,
                'total_qty' => $itemInPack * $cartItem->quantity,
                'per_unit_price' => $cartItem->item->price,
                'amount' => number_format($itemInPack * $cartItem->quantity * $cartItem->item->price, 2, '.', ''),
            ]);
        }
        
        $order = $this->getMaximumDiscount($order->id, $subTotal);
        
        $orderNumber = $this->generateRandomString(13);
        $order->order_number = $orderNumber;
        $order->shipping_cost = 0;
        $order->total = number_format($subTotal - $storeCredit - $order->discount, 2, '.', '');

        if ($storeCredit > $subTotal)
            $storeCredit = $subTotal;

        $order->store_credit = $storeCredit;

        $order->save();

        return response()->json(['success' => true, 'message' => encrypt($order->id)]);
    }

    public function index(Request $request) { 
        $user = Auth::user();
        $user->load('buyer');

        // Check Orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

        $countries = Country::orderBy('name')->get();
        $usStates = State::where('country_id', 1)->orderBy('name')->get()->toArray();
        $caStates =State::where('country_id', 2)->orderBy('name')->get()->toArray();

        if ($order->shipping_address_id == null)
            $address = BuyerShippingAddress::where('user_id', Auth::user()->id)->where('default', 1)->first();
        else
            $address = BuyerShippingAddress::where('id', $order->shipping_address_id)->first();

        $shippingAddresses = BuyerShippingAddress::where('user_id', Auth::user()->id)->get();

        return view('buyer.checkout.index', compact('user', 'countries', 'usStates', 'caStates',
            'order', 'address', 'shippingAddresses'))
            ->with('page_title', 'Checkout');
    }

    public function addressPost(Request $request) {
        // Check Orders
        $id = '';

        try {
            $id = decrypt($request->orders);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $shippingAddress = BuyerShippingAddress::where('id', $request->address_id)->with('state', 'country')->first();

        Order::where('id', $id)->update([
            'shipping_address_id' => $request->address_id,
            'shipping_location' => $shippingAddress->location,
            'shipping_address' => $shippingAddress->address,
            'shipping_city' => $shippingAddress->city,
            'shipping_state' => ($shippingAddress->state == null) ? $shippingAddress->state_text : $shippingAddress->state->name,
            'shipping_state_id' => $shippingAddress->state_id,
            'shipping_state_text' => $shippingAddress->state_text,
            'shipping_zip' => $shippingAddress->zipCode,
            'shipping_country' => $shippingAddress->country->name,
            'shipping_country_id' => $shippingAddress->country->id,
            'shipping_phone' => $shippingAddress->phone,
        ]);

        return redirect()->route('show_shipping_method', ['id' => $request->orders]);
    }

    public function shipping(Request $request) {
        // Check Orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

        $shipping_methods = AdminShipMethod::with('courier')->get();

       AuthorizeNet::authorizeCreditCard(10,true);

        return view('buyer.checkout.shipping', compact( 'order', 'shipping_methods'))->with('page_title', 'Checkout');
    }

    public function shippingPost(Request $request) {
        // Check orders
        $id = [];

        try {
            $id = decrypt($request->orderIds);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $request->validate([
            'shipping_method' => 'required'
        ]);


        $shippingMethod = AdminShipMethod::where('id', $request->shipping_method)->with('courier')->first();

        $order = Order::where('id', $id)->first();

        $order->shipping = $shippingMethod->name;
        $order->shipping_method_id = $shippingMethod->id;
        $order->shipping_cost = $shippingMethod->fee;
        $order->total = $order->total + $shippingMethod->fee;
        $order->save();

        return redirect()->route('show_payment', ['id' => $request->orderIds]);
    }

    public function payment(Request $request) {
        // Check orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

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

        return view('buyer.checkout.payment', compact('user', 'order'))->with('page_title', 'Checkout');
    }

    public function paymentPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'number' => 'required|max:191|min:6',
            'name' => 'required|max:191',
            'expiry' => 'required|date_format:"m/y"',
            'cvc' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validator->after(function ($validator) use($request) {
            // Card Number Check
            $card = CreditCard::validCreditCard($request->number);

            if (!$card['valid'])
                $validator->errors()->add('number', 'Invalid Card Number');

            // CVC Check
            $validCvc = CreditCard::validCvc($request->cvc, $card['type']);
            if (!$validCvc)
                $validator->errors()->add('cvc', 'Invalid CVC');

            // Expiry Check
            $tmp  = explode('/', $request->expiry);
            $validDate = CreditCard::validDate('20'.$tmp[1], $tmp[0]);
            if (!$validDate)
                $validator->errors()->add('expiry', 'Invalid Expiry');
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        Order::where('id', $id)->update([
            'card_number' => encrypt($request->number),
            'card_full_name' => encrypt($request->name),
            'card_expire' => encrypt($request->expiry),
            'card_cvc' => encrypt($request->cvc),
        ]);

     AuthorizeNet::authorizeCreditCard(10,true);

        return redirect()->route('show_checkout_review', ['id' => $request->id]);
    }

    public function review(Request $request) {
        // Check orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);


        $order = Order::where('id', $id)->with('user')->first();

        $temp = [];
        $cartItems = [];

        $cartObjs = CartItem::where('user_id', $order->user_id)
            ->with('item', 'color')
            ->get()
            ->sortBy(function ($useritem, $key) {
                return $useritem->item->vendor_meta_id;
            });

        foreach ($cartObjs as $obj) {
            $temp[$obj->item->id][] = $obj;
        }

        $itemCounter = 0;
        foreach ($temp as $itemId => $item) {
            $cartItems[$itemCounter] = $item;
            $itemCounter++;
        }

        $order->cartItems = $cartItems;
        $orders[] = $order;

        // Decrypt
        $cardNumber = '';
        $cardFullName = '';
        $cardExpire = '';
        $cardCvc = '';

        try {
            $cardNumber = decrypt($order->card_number);
            $cardNumber = str_repeat("*", (strlen($cardNumber) - 4)).substr($cardNumber,-4,4);
            $cardFullName = decrypt($order->card_full_name);
            $cardExpire = decrypt($order->card_expire);
            $cardCvc = decrypt($order->card_cvc);
        } catch (DecryptException $e) {

        }

        $order->card_number = $cardNumber;
        $order->card_full_name = $cardFullName;
        $order->card_expire = $cardExpire;
        $order->card_cvc = $cardCvc;

        return view('buyer.checkout.review', compact('order'))->with('page_title', 'Checkout');
    }

    public function complete(Request $request) {
        // Check orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

        if ($order->status == OrderStatus::$INIT) {
            $preOrder = Order::where('order_number', 'like', 'MF%')
                ->where('order_number', 'not like', '%BO%')
                ->orderBy('created_at', 'desc')
                ->first();

            $orderNumber = "MF10001";

            if ($preOrder) {
                $tmp = (int) substr($preOrder->order_number, 2);
                $orderNumber = "MF".($tmp+1);
            }

            $order->order_number = $orderNumber;
            $order->status = OrderStatus::$NEW_ORDER;

            if ($order->payment_type == 'PayPal') {
                $order->paypal_payment_id = $request->paymentId;
                $order->paypal_token = $request->token;
                $order->paypal_payer_id = $request->PayerID;
            }
            //$order->note = $request->note;
            $order->save();
            $user = Auth::user();
            $user->increment('order_count');

            $pdfData = $this->getPdfData($order);

            // Send Mail to Buyer
            /*Mail::send('emails.buyer.order_confirmation', ['order' => $order], function ($message) use ($order, $pdfData) {
                $message->subject('Order Confirmed');
                $message->to($order->email, $order->name);
                $message->attachData($pdfData, $order->order_number.'.pdf');
            });*/

            // Send Mail to Vendor
            /*$user = User::where('role', Role::$VENDOR)
                ->where('vendor_meta_id', $order->vendor_meta_id)->first();

            Mail::send('emails.vendor.new_order', ['order' => $order], function ($message) use ($order, $pdfData, $user) {
                $message->subject('New Order - '.$order->order_number);
                $message->to($user->email, $user->first_name.' '.$user->last_name);
                $message->attachData($pdfData, $order->order_number.'.pdf');
            });*/

            CartItem::where([])->delete();
        }

        //return redirect()->route('checkout_complete_view', ['id' => $request->id]);
        return view('buyer.checkout.complete', compact('order'));
    }

    public function completeView(Request $request) {
        // Check orders
        $id = [];

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

        return view('buyer.checkout.complete', compact('order'));
    }

    public function addressSelect(Request $request) {
        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {
            $id = '';
        }

        Order::where('id', $id)->update(['shipping_address_id' => $request->shippingId]);
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
    public function storcreditapply(Request $request){
        $order = Order::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
        $storeCredit = '';
        if ($request->storecredit && is_numeric($request->storecredit)) {
            $sc = StoreCredit::where('user_id', Auth::user()->id)->first(); 
            if (!$sc) {
                return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
            }

            if ($sc->amount < $request->storecredit)
                return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
            else
                $storeCredit = (float) $request->storecredit;
        }
        $subTotal = $order->subtotal;
        $order->total = number_format($subTotal - $storeCredit - $request->discount, 2, '.', ''); 
        $order->store_credit=$storeCredit;
        $order->save(); 
        return response()->json(['success' => true, 'order'=>$order, 'message' => 'Order Update.']); 
    }
    public function applyCoupon(Request $request) {
        
        $order = Order::where('id', $request->id)->where('user_id', Auth::user()->id)->first();

        if (!$order)
            return response()->json(['success' => false, 'message' => 'Invalid Order.']);
            
        $previous_discount = $order->discount;
        $discountFlash = 0.00;
        $coupon = Promotion::where('coupon_code', strtoupper(trim($request->coupon)))->where('status', 1)->first();
        if (!$coupon)
            return response()->json(['success' => false, 'message' => 'Invalid Coupon.']);
            
        if($order->coupon != null)
            return response()->json(['success' => false, 'message' => 'You have already used "' . $order->coupon .'" in this order.']);

        $previous = Order::where('user_id', Auth::user()->id)
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
                
        if ($previous->coupon == strtoupper(trim($request->coupon)))
            return response()->json(['success' => false, 'message' => 'Coupon code has already been used once.']);
        
        if($coupon->is_permanent == 0) {


            $startDate = strtotime($coupon->valid_from);
            $endDate = strtotime($coupon->valid_to);

            $currentTime = time();

            if($currentTime > $startDate && $currentTime < $endDate) {

            } else {

                return response()->json(['success' => false, 'message' => 'Coupon Expired.']);

            }

        }

        if ($coupon->multiple_use == 0) {
            $previous = Order::where('user_id', Auth::user()->id)
                ->where('status', '!=', OrderStatus::$INIT)
                ->where('coupon', $coupon->coupon_code)
                ->first();

            if ($previous)
                return response()->json(['success' => false, 'message' => 'Coupon code has already been used once.']);
        }

        $subTotal = $order->subtotal;
        $discount = 0;
        $coupon_details = '';
        $free_shipping = 0;

        if($coupon->to_price_1) {
        } else {
            $coupon->to_price_1 = 1000000;
        }

        if($subTotal >= $coupon->from_price_1 && $subTotal <= $coupon->to_price_1) {

            if($coupon->promotion_type == 'Percentage discount by order amount') {

                $discount = number_format($discountFlash + ($coupon->percentage_discount_1 / 100) * $subTotal, 2, '.', '');
                $coupon_details = '["' . $coupon->coupon_code . '" - ' . $coupon->percentage_discount_1 . '%]';

            } else {

                $discount = number_format($discountFlash + $coupon->unit_price_discount_1, 2, '.', '');
                $coupon_details = '["' . $coupon->coupon_code . '" - $' . $coupon->unit_price_discount_1 . ']';

            }
                    
            if($coupon->free_shipping_1 == 1) {
                $free_shipping = 1;
            }

        } else {

            if($coupon->to_price_2) {
            } else {
                $coupon->to_price_2 = 1000000;
            }

            if($subTotal >= $coupon->from_price_2 && $subTotal <= $coupon->to_price_2) {

                if($coupon->promotion_type == 'Percentage discount by order amount') {

                    $discount = number_format($discountFlash + ($coupon->percentage_discount_2 / 100) * $subTotal, 2, '.', '');
                    $coupon_details = '["' . $coupon->coupon_code . '" - ' . $coupon->percentage_discount_2 . '%]';

                } else {

                    $discount = number_format($discountFlash + $coupon->unit_price_discount_2, 2, '.', '');
                    $coupon_details = '["' . $coupon->coupon_code . '" - $' . $coupon->unit_price_discount_2 . ']';

                }
                    
                if($coupon->free_shipping_2 == 1) {
                    $free_shipping = 1;
                }

            } else {

                if($coupon->to_price_3) {
                } else {
                    $coupon->to_price_3 = 1000000;
                }

                if($subTotal >= $coupon->from_price_3 && $subTotal <= $coupon->to_price_3) {

                    if($coupon->promotion_type == 'Percentage discount by order amount') {

                        $discount = number_format($discountFlash + ($coupon->percentage_discount_3 / 100) * $subTotal, 2, '.', '');
                        $coupon_details = '["' . $coupon->coupon_code . '" - ' . $coupon->percentage_discount_3 . '%]';

                    } else {

                        $discount = number_format($discountFlash + $coupon->unit_price_discount_3, 2, '.', '');
                        $coupon_details = '["' . $coupon->coupon_code . '" - $' . $coupon->unit_price_discount_3 . ']';

                    }
                    
                    if($coupon->free_shipping_3 == 1) {
                        $free_shipping = 1;
                    }

                } else {

                    if($coupon->to_price_4) {
                    } else {
                        $coupon->to_price_4 = 1000000;
                    }

                    if($subTotal >= $coupon->from_price_4 && $subTotal <= $coupon->to_price_4) {

                        if($coupon->promotion_type == 'Percentage discount by order amount') {

                            $discount = number_format($discountFlash + ($coupon->percentage_discount_4 / 100) * $subTotal, 2, '.', '');
                            $coupon_details = '["' . $coupon->coupon_code . '" - ' . $coupon->percentage_discount_4 . '%]';

                        } else {

                            $discount = number_format($discountFlash + $coupon->unit_price_discount_4, 2, '.', '');
                            $coupon_details = '["' . $coupon->coupon_code . '" - $' . $coupon->unit_price_discount_4 . ']';

                        }
                    
                        if($coupon->free_shipping_4 == 1) {
                            $free_shipping = 1;
                        }

                    } else {

                        if($coupon->to_price_5) {
                        } else {
                            $coupon->to_price_5 = 1000000;
                        }

                        if($subTotal >= $coupon->from_price_5 && $subTotal <= $coupon->to_price_5) {

                            if($coupon->promotion_type == 'Percentage discount by order amount') {

                                $discount = number_format($discountFlash + ($coupon->percentage_discount_5 / 100) * $subTotal, 2, '.', '');
                                $coupon_details = '["' . $coupon->coupon_code . '" - ' . $coupon->percentage_discount_5 . '%]';

                            } else {

                                $discount = number_format($discountFlash + $coupon->unit_price_discount_5, 2, '.', '');
                                $coupon_details = '["' . $coupon->coupon_code . '" - $' . $coupon->unit_price_discount_5 . ']';

                            }
                    
                            if($coupon->free_shipping_5 == 1) {
                                $free_shipping = 1;
                            }

                        }

                    }
                }
            }

        }
        
        if($discount > $previous_discount) {

            $order->discount = $discount;
            $order->total = number_format($subTotal - $order->store_credit - $discount, 2, '.', '');
            $order->coupon = $coupon->coupon_code;
            $order->default_coupon_id = null;
            $order->promotion_details = $coupon_details;
            $order->free_shipping = $free_shipping;
            
            $order->save();
    
            return response()->json(['success' => true, 'message' => 'Success.', 'discount' => $order->discount, 'total' => $order->total, 'free_shipping' => $order->free_shipping]);
            
        } else {
            
            return response()->json(['success' => false, 'message' => 'You can use only one promotion in a single order.']);
            
        }   
    }

    public function getMaximumDiscount($orderId, $subTotal) {
        
        $maximum_discount = 0;
        $optimized_order = null;
        
        $coupons = Promotion::where('hasCouponCode', 0)->where('status', 1)->get();
        
        if(count($coupons) == 0) {
            
            $order = Order::where('id', $orderId)->first();
            $order->free_shipping = 0;
    
            $order->subtotal = number_format($subTotal, 2, '.', '');
            $order->discount = 0.00;
            $order->promotion_details = '';
            $order->shipping_cost = 0.00;
            
            return $order;
            
            
        }
        
        foreach($coupons as $coupon) {
            
            $order = Order::where('id', $orderId)->first();
            
            $discountflash = 0.00;
            $discount = 0;
            
            $coupon_details = '';
            $free_shipping = 0;
    
            $valid = 1;

            if($coupon->is_permanent == 0) {


                $startDate = strtotime($coupon->valid_from);
                $endDate = strtotime($coupon->valid_to);

                $currentTime = time();

                if($currentTime > $startDate && $currentTime < $endDate) {

                } else {

                    $valid = 0;

                }

            }

            $alreadyUsed = 0;

            if ($coupon->multiple_use == 0) {
                
                $previous = Order::where('user_id', Auth::user()->id)
                    ->where('status', '!=', OrderStatus::$INIT)
                    ->where('default_coupon_id', $coupon->id)
                    ->first();

                if ($previous) {

                    $alreadyUsed = 1;

                }
            }

            if($valid == 1 && $alreadyUsed == 0) {

                if($coupon->to_price_1) {
                } else {
                    $coupon->to_price_1 = 1000000;
                }

                if($subTotal >= $coupon->from_price_1 && $subTotal <= $coupon->to_price_1) {

                    if($coupon->promotion_type == 'Percentage discount by order amount') {

                        $discount = number_format($discountflash + ($coupon->percentage_discount_1 / 100) * $subTotal, 2, '.', '');
                        $coupon_details = '["' . $coupon->title . '" - ' . $coupon->percentage_discount_1 . '%]';

                    } else {

                        $discount = number_format($discountflash + $coupon->unit_price_discount_1,2, '.', '');
                        $coupon_details = '["' . $coupon->title . '" - $' . $coupon->unit_price_discount_1 . ']';

                    }
                    
                    if($coupon->free_shipping_1 == 1) {
                        
                        $free_shipping = 1;
                        
                    }

                } else {

                    if($coupon->to_price_2) {
                    } else {
                        $coupon->to_price_2 = 1000000;
                    }

                    if($subTotal >= $coupon->from_price_2 && $subTotal <= $coupon->to_price_2) {

                        if($coupon->promotion_type == 'Percentage discount by order amount') {

                            $discount = number_format($discountflash + ($coupon->percentage_discount_2 / 100) * $subTotal, 2, '.', '');
                            $coupon_details = '["' . $coupon->title . '" - ' . $coupon->percentage_discount_2 . '%]';

                        } else {

                            $discount = number_format($discountflash + $coupon->unit_price_discount_2, 2, '.', '');
                            $coupon_details = '["' . $coupon->title . '" - $' . $coupon->unit_price_discount_2 . ']';

                        }
                    
                        if($coupon->free_shipping_2 == 1) {
                            
                            $free_shipping = 1;
                            
                        }

                    } else {

                        if($coupon->to_price_3) {
                        } else {
                            $coupon->to_price_3 = 1000000;
                        }

                        if($subTotal >= $coupon->from_price_3 && $subTotal <= $coupon->to_price_3) {

                            if($coupon->promotion_type == 'Percentage discount by order amount') {

                                $discount = number_format($discountflash + ($coupon->percentage_discount_3 / 100) * $subTotal, 2, '.', '');
                                $coupon_details = '["' . $coupon->title . '" - ' . $coupon->percentage_discount_3 . '%]';

                            } else {

                                $discount = number_format($discountflash + $coupon->unit_price_discount_3, 2, '.', '');
                                $coupon_details = '["' . $coupon->title . '" - $' . $coupon->unit_price_discount_3 . ']';

                            }
                    
                            if($coupon->free_shipping_3 == 1) {
                                
                                $free_shipping = 1;
                                
                            }

                        } else {

                            if($coupon->to_price_4) {
                            } else {
                                $coupon->to_price_4 = 1000000;
                            }

                            if($subTotal >= $coupon->from_price_4 && $subTotal <= $coupon->to_price_4) {

                                if($coupon->promotion_type == 'Percentage discount by order amount') {

                                    $discount = number_format($discountflash + ($coupon->percentage_discount_4 / 100) * $subTotal, 2, '.', '');
                                    $coupon_details = '["' . $coupon->title . '" - ' . $coupon->percentage_discount_4 . '%]';

                                } else {

                                    $discount = number_format($discountflash + $coupon->unit_price_discount_4, 2, '.', '');
                                    $coupon_details = '["' . $coupon->title . '" - $' . $coupon->unit_price_discount_4. ']';

                                }
                    
                                if($coupon->free_shipping_4 == 1) {
                                    
                                    $free_shipping = 1;
                                    
                                }

                            } else {

                                if($coupon->to_price_5) {
                                } else {
                                    $coupon->to_price_5 = 1000000;
                                }

                                if($subTotal >= $coupon->from_price_5 && $subTotal <= $coupon->to_price_5) {

                                    if($coupon->promotion_type == 'Percentage discount by order amount') {

                                        $discount = number_format($discountflash + ($coupon->percentage_discount_5 / 100) * $subTotal, 2, '.', '');
                                        $coupon_details = '["' . $coupon->title . '" - ' . $coupon->percentage_discount_5 . '%]';

                                    } else {

                                        $discount = number_format($discountflash + $coupon->unit_price_discount_5, 2, '.', '');
                                        $coupon_details = '["' . $coupon->title . '" - $' . $coupon->unit_price_discount_5 . ']';

                                    }
                    
                                    if($coupon->free_shipping_5 == 1) {
                                        
                                        $free_shipping = 1;
                                        
                                    }

                                }

                            }
                        }
                    }

                }

                $order->default_coupon_id = $coupon->id;
                $order->free_shipping = $free_shipping;

            }
    
            $order->subtotal = number_format($subTotal, 2, '.', '');
            $order->discount = $discount;
            $order->promotion_details = $coupon_details;
            $order->shipping_cost = 0;
            
            if($optimized_order == null) {
                $optimized_order = $order;
            }

            if($discount > $maximum_discount) {
                
                $maximum_discount = $discount;
                $optimized_order = $order;
                
            }
            
        }
        
        return $optimized_order;
        
    }

    public function singlePageCheckout(Request $request) {
        $user = Auth::user();
        $user->load('buyer');

        // Check Orders
        $id = '';

        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }

        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->first();

        $countries = Country::orderBy('name')->get();
        $usStates = State::where('country_id', 1)->orderBy('name')->get()->toArray();
        $caStates =State::where('country_id', 2)->orderBy('name')->get()->toArray();

        if ($order->shipping_address_id == null)
            $address = BuyerShippingAddress::where('user_id', Auth::user()->id)->where('default', 1)->first();
        else
            $address = BuyerShippingAddress::where('id', $order->shipping_address_id)->first();

        $shippingAddresses = BuyerShippingAddress::where('user_id', Auth::user()->id)->with('state', 'country')->get();
        $shipping_methods = AdminShipMethod::with('courier')->get();
        $storecredit = '';
        $storecredit = StoreCredit::where('user_id', Auth::user()->id)->first();
//  dd($storecredit);
        return view('buyer.checkout.single', compact('address', 'shippingAddresses', 'user',
            'shipping_methods', 'order', 'countries', 'usStates','storecredit', 'caStates'));
    }

    public function singlePageCheckoutPost(Request $request) {
        
        $rules = [
            'address_id' => 'required',
            'paymentMethod' => 'required|integer|min:1|max:3',
            'shipping_method' => 'required',
            'factoryLocation' => 'required', 
            'factoryAddress' => 'required', 
            'factoryCity' => 'required', 
            'factoryStateSelect' => 'required',
            'factoryCountry' => 'required',
            'factoryPhone' => 'required',
            'factoryZipCode' => 'required',
        ];

        if ($request->paymentMethod == '2') {
            $rules['number'] = 'required|max:191|min:6';
            $rules['name'] = 'required|max:191';
            $rules['expiry'] = 'required|date_format:"m/y"';
            $rules['cvc'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->paymentMethod == '2') {
            $validator->after(function ($validator) use($request) {
                // Card Number Check
                $card = CreditCard::validCreditCard($request->number);
                if (!$card['valid'])
                    $validator->errors()->add('number', 'Invalid Card Number');

                // CVC Check
                $validCvc = CreditCard::validCvc($request->cvc, $card['type']);
                if (!$validCvc)
                    $validator->errors()->add('cvc', 'Invalid CVC');

                // Expiry Check
                $tmp  = explode('/', $request->expiry);
                $validDate = CreditCard::validDate('20'.$tmp[1], $tmp[0]);
                if (!$validDate)
                    $validator->errors()->add('expiry', 'Invalid Expiry');
            });

                if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // Check Orders
        $id = '';
        try {
            $id = decrypt($request->id);
        } catch (DecryptException $e) {

        }
        
        
        if ($id == '')
            abort(404);

        $order = Order::where('id', $id)->where('status', OrderStatus::$INIT)->first();
        if (!$order)
            abort(404);

        $shipmentMethod = AdminShipMethod::where('id', $request->shipping_method)->first();
        $shippingAddress = BuyerShippingAddress::where('id', $request->address_id)->with('state', 'country')->first();

        if ($shipmentMethod->fee === null)
        $shipmentMethod->fee = 0;
        
        if($order->free_shipping == 1) {
            
            $shipmentMethod->fee = 0;
            
        }

        if ($request->paymentMethod != '3') {
            $preOrder = Order::where('order_number', 'like', 'BC%')
                ->where('order_number', 'not like', '%DO%')
                ->orderBy('created_at', 'desc')
                ->first();
            $orderNumber = "BC10001";

            if($preOrder){
                $tmp = (int) substr($preOrder->order_number, 2);
            }
            
            order_number_create:{
                if ($preOrder) {
                    $orderNumber = "BC".($tmp+1);
                    
                    $preOrder_new = Order::where('order_number', $orderNumber)->get();
                    
                    if( $preOrder_new->count() > 0){
                        $tmp++;
                        goto order_number_create; 
                    }
                    
                }
            }

            $order->status = OrderStatus::$NEW_ORDER;
            $order->order_number = $orderNumber;
        }

        $order->user_id = Auth::user()->id;
        $order->email = Auth::user()->email;
        $order->company_name = Auth::user()->buyer->company_name;
        $order->shipping_method_id = $shipmentMethod->id;
        $order->shipping = $shipmentMethod->name;
        $order->can_call = $request->can_call;

        $order->shipping_address_id = $request->address_id;
        $order->shipping_location = $shippingAddress->location;
        $order->shipping_address = $shippingAddress->address;
        $order->shipping_unit = $shippingAddress->unit;
        $order->shipping_city = $shippingAddress->city;
        $order->shipping_state = ($shippingAddress->state == null) ? $shippingAddress->state_text : $shippingAddress->state->code;
        $order->shipping_state_id = $shippingAddress->state_id;
        $order->shipping_state_text = $shippingAddress->state_text;
        $order->shipping_zip = $shippingAddress->zip;
        $order->shipping_country = $shippingAddress->country->name;
        $order->shipping_country_id = $shippingAddress->country->id;
        $order->shipping_phone = $shippingAddress->phone;
        $order->billing_location = $request->factoryLocation;
        $order->billing_address = $request->factoryAddress;
        $order->billing_unit = $request->factoryUnit;
        $order->billing_city = $request->factoryCity;
        $order->billing_state = $request->factorystate;
        $order->billing_state_id = $request->factoryStateSelect;
        $order->billing_zip = $request->factoryZipCode;
        $order->billing_country = $request->factoryCountry;
        $order->billing_phone = $request->factoryPhone;

        $order->shipping_cost = $shipmentMethod->fee;
        $order->total = number_format(($order->subtotal - $order->discount) + ($shipmentMethod->fee - $order->store_credit), 2, '.', '');

        if ($request->paymentMethod == '2') {
            $order->card_number = encrypt($request->number);
            $order->card_full_name = encrypt($request->name);
            $order->card_expire = encrypt($request->expiry);
            $order->card_cvc = encrypt($request->cvc);
            $order->token    = $request->stripeToken;

            $order->payment_type = 'Credit Card';
            $card = CreditCard::validCreditCard($request->number);
            $order->payment_type = $card['type'];

        } else if ($request->paymentMethod == '1') {
            $order->payment_type = 'Wire Transfer';
        } else if ($request->paymentMethod == '3') {
            $order->payment_type = 'PayPal';
        }

        $order->note = $request->order_note;
        $order->save();

        if($order->store_credit > 0) {
            $sc = StoreCredit::where('user_id', Auth::user()->id)->first();
            $sc->amount = $sc->amount - $order->store_credit;
            $sc->save();
        }

        $user = Auth::user();
        $user->increment('order_count');

        $pdfData = $this->getPdfData($order);
        
        // Send Mail to Buyer
        $order_time = Carbon::parse($order->created_at)->format('F d ,Y h:i:s A ');
//        Mail::send('emails.buyer.order_confirmation', ['order' => $order, 'order_time' => $order_time], function ($message) use ($order, $pdfData) {
//            $message->subject('Order Confirmed');
//            $message->to($order->email, $order->name);
//            $message->attachData($pdfData, $order->order_number . '.pdf');
//        });

        //Send Mail to Vendor
//        $user = User::where('role', Role::$EMPLOYEE)->first();
//        Mail::send('emails.vendor.new_order', ['order' => $order, 'order_time' => $order_time], function ($message) use ($order, $pdfData, $user) {
//            $message->subject('New Order - '.$order->order_number);
//            $message->to($user->email, $user->first_name.' '.$user->last_name);
//            $message->attachData($pdfData, $order->order_number.'.pdf');
//        });


        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        foreach ($cartItems as $cartItem) {
            $itemInventory = ItemInv::where('item_id', $cartItem->item_id)->where('color_id', $cartItem->color->id)->first();
            if(isset($itemInventory)){
                ItemInv::where('item_id', $cartItem->item_id)->where('color_id', $cartItem->color->id)->update([
                    'qty' => $itemInventory->qty - $cartItem->quantity
                ]);
            }
        }

        CartItem::where([])->where('user_id',auth()->user()->id)->delete();
        
        return view('buyer.checkout.complete', compact('order'));
    }

    /* Authorize .NET */
    public function authorizeAndCapture(Request $request) {
        $orderId = $request->order;
        $order = Order::where('id', $orderId)->with('user', 'items')->first();

        $orderDesc = '';
        $oInc = 1;
        foreach ($order->items as $oitem){
            $orderDesc.= $oInc.'. Style No: '. $oitem->style_no .', ';
            $oInc = $oInc + 1;
        }

        $invoiceId = $order->order_number;

        $authorize_info = $order->authorize_info;

        $cardNumber = '';
        $cardFullName = '';
        $cardExpire = '';
        $cardCvc = '';

        try {
            $cardNumber = decrypt($order->card_number);
            //$cardNumber = str_repeat("*", (strlen($cardNumber) - 4)).substr($cardNumber,-4,4);
            $cardFullName = decrypt($order->card_full_name);
            $cardExpire = decrypt($order->card_expire);
            $cardCvc = decrypt($order->card_cvc);
        } catch (DecryptException $e) {

        }

        $fName =  $order->user->first_name;
        $lName =  $order->user->last_name;
        $b_address =  $order->billing_address;
        $b_city =  $order->billing_city;
        $b_state =  $order->billing_state;
        $b_zip =  $order->billing_zip;
        $b_country =  $order->billing_country;
        $user_id = $order->user->id;
        $user_email = $order->user->email;


        $s_address =  $order->shipping_address;
        $s_city =  $order->shipping_city;
        $s_state =  $order->shipping_state;
        $s_zip =  $order->shipping_zip;
        $s_country =  $order->shipping_country;

 
        $amount = $order->total;
        $expireData = explode('/', $cardExpire);
        $exYear = 2000 + intval($expireData[1]);
        $exMonth = $expireData[0];
        $expiry = $exYear.'-'.$exMonth;

        // Common setup for API credentials
        define("AUTHORIZENET_LOG_FILE", storage_path('logs/laravel.log'));
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref'.time();


        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expiry);
        $creditCard->setCardCode($cardCvc);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);


        // Create order information
        $orderInfo = new AnetAPI\OrderType();
        $orderInfo->setInvoiceNumber($invoiceId);
        $orderInfo->setDescription($orderDesc);



        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($fName);
        $customerAddress->setLastName($lName);
       //$customerAddress->setCompany("Souveniropolis");
        $customerAddress->setAddress($b_address);
        $customerAddress->setCity($b_city);
        $customerAddress->setState($b_state);
        $customerAddress->setZip($b_zip);
        $customerAddress->setCountry($b_country);


        // Set the customer's Shipping Address
        $customerSAddress = new AnetAPI\CustomerAddressType();
        $customerSAddress->setFirstName($fName);
        $customerSAddress->setLastName($lName);
        //$customerAddress->setCompany("Souveniropolis");
        $customerSAddress->setAddress($s_address);
        $customerSAddress->setCity($s_city);
        $customerSAddress->setState($s_state);
        $customerSAddress->setZip($s_zip);
        $customerSAddress->setCountry($s_country);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($user_id);
        $customerData->setEmail($user_email);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        //$transactionRequestType->setTransactionType("authOnlyTransaction");
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        //$transactionRequestType->setShipping($amount);
        $transactionRequestType->setAmount(round($amount, 2));
        $transactionRequestType->setOrder($orderInfo);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setShipTo($customerSAddress);
        $transactionRequestType->setCustomer($customerData);


        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        //$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        $response = $controller->executeWithApiResponse(config('services.authorize.endpoint'));

        $status_avs_hint = array("A" => 'Address (street) matches, ZIP code does not', 'B' => 'Address information not provided for AVS check',
            'E' => 'AVS error', 'G' => 'Non-U.S. card issuing bank', 'N' => 'No match on address (street) and ZIP code',
            'P' => 'AVS not applicable for this transaction', 'R' => 'Retry – System unavailable or timed out', 'S' => 'Service not supported by issuer',
            'U' => 'Address information is unavailable', 'W' => '9 digit ZIP code matches, address (street) does not','X'=>'Street address and 9-digit postal code match', 'Y' => 'Address (street) and 5 digit ZIP code match',
            'Z' => '5 digit ZIP matches, Address (Street) does not'
        );

        $status_cvv_hint = array('M' => 'Successful Match', 'N' => 'Does NOT Match', 'P'=> 'Is NOT Processed',
            'S' => 'Should be on card, but is not indicated', 'U' => 'Issuer is not certified or has not provided encryption key'
        );



        $transactionInfo = (object) array();
        Log::error('authorize error : ' . json_encode($response));
        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode()) {
                //pr($response);
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $transactionInfo->status = 'Success';
                    $transactionInfo->message = date('Y-m-d H:i:s') . " Authorized Only with ID: " . $tresponse->getTransId();
                    $transactionInfo->transaction_code = $tresponse->getTransId();
                    $transactionInfo->transaction_response_code = $tresponse->getResponseCode();
                    $transactionInfo->message_code = $tresponse->getMessages()[0]->getCode();
                    $transactionInfo->auth_code = $tresponse->getAuthCode();
                    $transactionInfo->avs_code = $tresponse->getAvsResultCode();
                    $transactionInfo->cvv_code = $tresponse->getCvvResultCode();
                    $transactionInfo->desc = $tresponse->getMessages()[0]->getDescription();
                    if($transactionInfo->avs_code){
                        $transactionInfo->avs_message = $status_avs_hint[$transactionInfo->avs_code];
                    }
                    if($transactionInfo->cvv_code){
                        $transactionInfo->cvv_message = $status_cvv_hint[$transactionInfo->cvv_code];
                    }
                } else {
                    $transactionInfo->status = 'Failed';
                    $transactionInfo->message = date('Y-m-d H:i:s') . ' Auth Failed';
                    $transactionInfo->error_code = $tresponse->getErrors()[0]->getErrorCode();
                    $transactionInfo->error_message = $tresponse->getErrors()[0]->getErrorText();
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $transactionInfo->status = 'Failed';
                $transactionInfo->message = date('Y-m-d H:i:s') . ' Auth Failed';
                $tresponse = $response->getTransactionResponse();

                $transactionInfo->error_code = $tresponse->getErrors()[0]->getErrorCode();
                $transactionInfo->error_message = $tresponse->getErrors()[0]->getErrorText();
            }
        } else {
            $transactionInfo->status = 'Failed';
            $transactionInfo->message = 'No Response(Failed)';
        }
        $tInfo = json_encode($transactionInfo);
        if(!(isset($authorize_info))){
            DB::table('orders')->where('id', $orderId)->update(['authorize_info' => $tInfo,'aStatus'=>$transactionInfo->status]);
        }

        AuthorizeLog::create(['order_id' => $orderId,'authorize_type'=>'ShippingCharge',
            'authorize_info'=>$tInfo,'status'=>$transactionInfo->status,'responseCode'=>(isset($transactionInfo->transaction_response_code))?$transactionInfo->transaction_response_code:null,
            'authorize_message'=>(isset($transactionInfo->message_code))?$transactionInfo->message_code:null]);
        $redirectUrl = route('admin_order_details', ['order' => $orderId]);
        return response()->json(['success' => true, 'url' => $redirectUrl, 'transaction' => $transactionInfo]);
    }
}
