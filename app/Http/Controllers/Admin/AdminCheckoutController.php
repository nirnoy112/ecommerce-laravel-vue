<?php

namespace App\Http\Controllers\Admin;

use App\Model\Promotion;
use PDF;
use Mail;
use Session;
use Validator;
use CreditCard;
use Stripe\Stripe;
use App\Model\Page;
use App\Model\User;
use App\Model\Order;
use App\Model\State;
use PayPal\Api\Item;
use App\Model\Coupon;
use PayPal\Api\Payer;
use App\Model\Country;
use App\Model\ItemInv;
use PayPal\Api\Amount;
use App\Model\CartItem;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use App\Model\MetaBuyer;
use App\Model\OrderItem;
use PayPal\Api\ItemList;
use App\Enumeration\Role;
use App\Model\MetaVendor;
use App\Model\StoreCredit;
use App\Model\VendorImage;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\Model\ShippingMethod;
use App\Model\AdminShipMethod;
use Carbon\Carbon;

// PayPal
use App\Enumeration\CouponType;
use PayPal\Api\ShippingAddress;
use App\Enumeration\OrderStatus;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\DB;
use App\Model\BuyerShippingAddress;
use Illuminate\Support\Facades\URL;
use App\Enumeration\PageEnumeration;
use App\Enumeration\VendorImageType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PayPal\Auth\OAuthTokenCredential;

// For Authorize Checkout
use Illuminate\Support\Facades\Redirect;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminCheckoutController extends Controller
{
    public function create(Request $request) {

        $sessionUser = session('order_customer_id' , null);

        $user = User::find($sessionUser);

        $user->load('buyer');
        $billing_location = '';
        $billing_address = '';
        $billing_unit = '';
        $billing_city = '';
        $billing_state = '';
        $billing_state_id = '';
        $billing_state_text = '';
        $billing_zip = '';
        $billing_country = '';
        $billing_country_id = '';
        $billing_phone = ''; 
        if($user->buyer){
            $billing_location = $user->buyer->billing_location;
            $billing_address = $user->buyer->billing_address;
            $billing_unit = $user->buyer->billing_unit;
            $billing_city = $user->buyer->billing_city;
            $billing_state = ($user->buyer->billingState == null) ? $user->buyer->billing_state : $user->buyer->billingState->code;
            $billing_state_id = $user->buyer->billing_state_id;
            $billing_state_text = $user->buyer->billing_state;
            $billing_zip = $user->buyer->billing_zip;
            $billing_country = $user->buyer->billingCountry;
            $billing_country_id = $user->buyer->billing_country_id;
            $billing_phone = $user->buyer->billing_phone;
        }

        $meta_vendor = MetaVendor::where('verified', 1)->where('active', 1)->get()->first();
        $minimum_order_amount = ( isset($meta_vendor->min_order) && $meta_vendor->min_order != '' ) ? $meta_vendor->min_order : 0;  
        
        $order = Order::create([
            'status' => OrderStatus::$INIT,
            'user_id' => $user->id,
            'name' => $user->first_name.' '.$user->last_name, 
            'email' => $user->email,
            'billing_location' => $billing_location,
            'billing_address' => $billing_address,
            'billing_unit' => $billing_unit,
            'billing_city' => $billing_city,
            'billing_state' => $billing_state,
            'billing_state_id' => $billing_state_id,
            'billing_state_text' => $billing_state_text,
            'billing_zip' => $billing_zip,
            'billing_country' => $billing_country,
            'billing_country_id' => $billing_country_id,
            'billing_phone' => $billing_phone,
        ]);
        
        $storeCredit = 0;

        // if ($request->storeCredit && is_numeric($request->storeCredit)) {
        //     $sc = StoreCredit::where('user_id', Auth::user()->id)->first();

        //     if (!$sc) {
        //         return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
        //     }

        //     if ($sc->amount < $request->storeCredit)
        //         return response()->json(['success' => false, 'message' => 'Insufficient Store Credit.']);
        //     else
        //         $storeCredit = (float) $request->storeCredit;
        // }

        // calculate total amount
        $cartItems = CartItem::where('user_id', $order->user_id)->get();

        $subTotal = 0;
        foreach ($cartItems as $cartItem) {
            $subTotal += $cartItem->quantity * $cartItem->item->price;
        }

        if ( $minimum_order_amount > $subTotal ) {
            return response()->json(['success' => false, 'message' => 'Minimum order amount is : ' . $minimum_order_amount]);
        }

        // Cart Items
        $cartItems = CartItem::where('user_id', $order->user_id)->get();
        $subTotal = 0;
        $orderNumber = $this->generateRandomString(13);

        foreach ($cartItems as $cartItem) {  
            $subTotal += number_format($cartItem->quantity *  $cartItem->item->price, 2, '.',''); 
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'style_no' => $cartItem->item->style_no,
                'color' => $cartItem->color->name ?? null,
                'size' => $cartItem->size_id,  
                'qty' => $cartItem->quantity,
                'total_qty' => $cartItem->quantity,
                'per_unit_price' => $cartItem->item->price,
                'amount' => number_format( $cartItem->item->price, 2, '.', ''),
            ]);
        }

        $descountflash=$order->discount;
        $promotion = null;
        $getdescount=0;

        if(!empty($promotion)){
            if($subTotal >= $promotion->credit){
                if($promotion->type==2){
                    $descount=number_format($subTotal * $promotion->amount /100);
                    $getdescount = $descountflash + $descount;
                }else{
                    $getdescount = $descountflash + $promotion->amount;
                }
            }
        }

        $order->order_number = $orderNumber;
        $order->subtotal = number_format($subTotal, 2, '.', '');
        $order->discount = (string) $getdescount;
        $order->shipping_cost = 0;
        $order->total = number_format($subTotal-$storeCredit-$getdescount, 2, '.', '');

        if ($storeCredit > $subTotal)
            $storeCredit = $subTotal;

        $order->store_credit = $storeCredit;

        $order->save();

        return response()->json(['success' => true, 'message' => encrypt($order->id)]);
    }

    public function singlePageCheckout(Request $request){
        $sessionUser = session('order_customer_id' , null);

        $user = User::find($sessionUser);

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
            $address = BuyerShippingAddress::where('user_id', $user->id)->where('default', 1)->first();
        else
            $address = BuyerShippingAddress::where('id', $order->shipping_address_id)->first();

        $shippingAddresses = BuyerShippingAddress::where('user_id', $user->id)->with('state', 'country')->get();
        $shipping_methods = AdminShipMethod::with('courier')->get();

        return view('admin.dashboard.admin_order.single', compact('address', 'shippingAddresses', 'user',
            'shipping_methods', 'order', 'countries', 'usStates', 'caStates'))->with('page_title', 'Checkout');
    }

    public function singlePageCheckoutPost(Request $request) {

        $sessionUser = session('order_customer_id' , null);

        $user = User::find($sessionUser);

        $rules = [
            'address_id' => 'required',
            'paymentMethod' => 'required|integer|min:1|max:3',
            'shipping_method' => 'required',
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

        if ($request->paymentMethod != '3') {
            $preOrder = Order::where('order_number', 'like', 'MM%')
                ->where('order_number', 'not like', '%MO%')
                ->orderBy('created_at', 'desc')
                ->first();
            $orderNumber = "MM10001";

            if ($preOrder) {
                $tmp = (int) substr($preOrder->order_number, 2);
                $orderNumber = "MM".($tmp+1);
            }

            $order->status = OrderStatus::$NEW_ORDER;
            $order->order_number = $orderNumber;
        }

        $order->user_id = $user->id;
        $order->email = $user->email;
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
        $order->shipping_cost = $shipmentMethod->fee;

        // Point system start
        $pointSetting = DB::table('point_system_settings')->first();
        //calculate point for order
        if(!empty($pointSetting)){
            $newPoints = ($pointSetting->point_rewards * $order->subtotal) / $pointSetting->cost_dollars;
            $newPoints = (int) floor($newPoints);

            $oldPoints = MetaBuyer::select('points')->where('user_id',$user->id)->first();
            $oldPoints =  $oldPoints->points;
            $totalPoints = $oldPoints + $newPoints;

            $order->points = $newPoints;
            MetaBuyer::where('user_id',$user->id)->update(['points'=> $totalPoints]);
        }
        // Point system end


        $order->total = number_format(($order->subtotal - $order->discount) + ($shipmentMethod->fee - $order->store_credit), 2, '.', '');
        if ($request->paymentMethod == '2') {
            $order->card_number = encrypt($request->number);
            $order->card_full_name = encrypt($request->name);
            $order->card_expire = encrypt($request->expiry);
            $order->card_cvc = encrypt($request->cvc);

            $order->payment_type = 'Credit Card';
            $card = CreditCard::validCreditCard($request->number);
            $order->payment_type = $card['type'];

            //$authorize = $this->authorizeOnly($order);
            // $order->authorize_info = $authorize;

        } else if ($request->paymentMethod == '1') {
            $order->payment_type = 'Wire Transfer';
        } else if ($request->paymentMethod == '3') {
            $order->payment_type = 'PayPal';
        }

        $order->note = $request->order_note;
        $order->save();

        $user = $user;
        $user->increment('order_count');


        if ($request->paymentMethod == '3') {
            $paypal_conf = \Config::get('paypal');
            $this->_api_context = new ApiContext(new OAuthTokenCredential(
                    $paypal_conf['client_id'],
                    $paypal_conf['secret'])
            );
            $this->_api_context->setConfig($paypal_conf['settings']);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $items = [];
            $item_list = new ItemList();

            foreach ($order->items as $i) {
                $item = new Item();
                $item->setName($i->style_no.' - '.$i->color)
                    ->setCurrency('USD')
                    ->setQuantity($i->total_qty)
                    ->setPrice($i->per_unit_price);

                $items[] = $item;
            }

            $itemTmp = new \PayPal\Api\Item();
            $itemTmp->setName('Store Credit')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice('-'.number_format($order->store_credit, 2, '.', ''));

            $items[] = $itemTmp;

            $item_list->setItems($items);

            $details = new Details();
            $details->setShipping($order->shipping_cost)
                ->setTax(0)
                ->setSubtotal(($order->subtotal - $order->discount)- $order->store_credit);

            $itemTmp->setName('Discount')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice('-'.number_format($order->discount, 2, '.', ''));

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal( ($order->subtotal - $order->discount) + $order->shipping_cost - $order->store_credit)
                ->setDetails($details);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('https://www.fameaccoessories.com')
                ->setInvoiceNumber($order->order_number);

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(route('checkout_complete', ['id' => $request->id]))
                ->setCancelUrl(route('show_cart'));
            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));

            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::to('/');
                } else {
                    \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::to('/');
                }
            }
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }
            \Session::put('error', 'Unknown error occurred');
            return Redirect::to('/');
        }

        $cartItems = CartItem::where('user_id', $user->id)->get();
        foreach ($cartItems as $cartItem) {
            $itemInventory = ItemInv::where('item_id', $cartItem->item_id)->first();
            
            if(isset($itemInventory)){
                ItemInv::where('item_id', $cartItem->item_id)
                        ->update([
                            'qty' => $itemInventory->qty - $cartItem->quantity
                        ]);
            }
        }

        CartItem::where([])->where('user_id', $user->id)->delete();

        $pdfData = $this->getPdfData($order);

        try {
            $order_time = Carbon::parse($order->created_at)->format('F d ,Y h:i:s A ');

            // Send Mail to Buyer
            // Mail::send('emails.buyer.order_confirmation', ['order' => $order, 'order_time' => $order_time], function ($message) use ($order, $pdfData) {
            //     $message->subject('Order Confirmed');
            //     $message->to($order->email, $order->name);
            //     $message->attachData($pdfData, $order->order_number . '.pdf');
            // });

            // Send Mail to Vendor
            $user = User::where('role', Role::$EMPLOYEE)->first();

            // Mail::send('emails.vendor.new_order', ['order' => $order], function ($message) use ($order, $pdfData, $user) {
            //     $message->subject('New Order - '.$order->order_number);
            //     $message->to($user->email, $user->first_name.' '.$user->last_name);
            //     $message->attachData($pdfData, $order->order_number.'.pdf');
            // });
        } catch (\Exception $exception) {

        }

        return view('admin.dashboard.admin_order.complete', compact('order'))->with('page_title', 'Checkout Complete');
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
            $preOrder = Order::where('order_number', 'like', 'CQ%')
                ->where('order_number', 'not like', '%BO%')
                ->orderBy('created_at', 'desc')
                ->first();

            $orderNumber = "CQ10001";

            if ($preOrder) {
                $tmp = (int) substr($preOrder->order_number, 2);
                $orderNumber = "CQ".($tmp+1);
            }

            $order->order_number = $orderNumber;
            $order->status = OrderStatus::$NEW_ORDER;

            if ($order->payment_type == 'PayPal') {
                $order->paypal_payment_id = $request->paymentId;
                $order->paypal_token = $request->token;
                $order->paypal_payer_id = $request->PayerID;
            }

            $order->save();
            $user = Auth::user();
            $user->increment('order_count');

            CartItem::where([])->delete();
        }
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

    public function addShippingAddress(Request $request) {

        $sessionUser = session('order_customer_id' , null);

        $user = User::find($sessionUser);

        $state_id = null;
        $state = null;

        if ($request->location == "INT")
            $state = $request->state;
        else
            $state_id = $request->stateSelect;

        $address = BuyerShippingAddress::create([
            'user_id' => $user->id,
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
        ]);

        return response()->json($address->toArray());
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

        // Vendor Logo
        $logo_path = '';
        $vendorLogo = VendorImage::where('status', 1)
            ->where('type', VendorImageType::$LOGO)
            ->first();

        if ($vendorLogo)
            $logo_path = public_path($vendorLogo->image_path);

        $vendor = MetaVendor::where('id', 1)->first();
        $order->vendor = $vendor;

        $content = '';

        $page = Page::where('page_id', PageEnumeration::$RETURN_POLICY)->first();
        if ($page)
            $content = $page->content;

        $data = [
            'all_items' => [$allItems],
            'orders' => [$order],
            'logo_paths' => [$logo_path],
            'return_policy_description' => $vendor->size_chart
        ];

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admin.dashboard.orders.pdf.with_image', $data);
        return $pdf->output();
    }

    public function applyCoupon(Request $request) {
        return response()->json(['success' => false, 'message' => 'Invalid Coupon.']);
        $sessionUser = session('order_customer_id' , null);

        $user = User::find($sessionUser);

        $order = Order::where('id', $request->id)->where('user_id', $user->id)->first();

        if (!$order)
            return response()->json(['success' => false, 'message' => 'Invalid Order.']);

        $coupon = Coupon::where('name', trim($request->coupon))->first();

        if (!$coupon)
            return response()->json(['success' => false, 'message' => 'Invalid Coupon.']);

        if ($coupon->multiple_use == 0) {
            $previous = Order::where('user_id', $user->id)
                ->where('status', '!=', OrderStatus::$INIT)
                ->where('coupon', $coupon->name)
                ->first();

            if ($previous)
                return response()->json(['success' => false, 'message' => 'Already used this coupon.']);
        }

        $subTotal = $order->subtotal;
        $discount = 0;

        if ($coupon->type == CouponType::$FIXED_PRICE)
            $discount = $coupon->amount;
        else if ($coupon->type == CouponType::$PERCENTAGE){
            $discount = ($coupon->amount / 100) * $subTotal;
        } else if ($coupon->type == CouponType::$FREE_SHIPPING){
            $discount = 0;
        }

        if ($discount > $subTotal) {
            $discount = $subTotal; }

        $descountflash=$order->discount;
        if ($descountflash){
            $Finaldiscount = $discount + $descountflash;
        }
        else {
            $Finaldiscount = $discount;
        }


        $order->discount = $Finaldiscount;
        $order->total = $subTotal - $Finaldiscount;
        $order->coupon = $coupon->name;
        $order->coupon_type = $coupon->type;
        $order->coupon_amount = $coupon->amount;
        $order->coupon_description = $coupon->description;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Success.']);
    }
}
