<?php

namespace App\Http\Controllers\Api;

use App\Model\Item;
use App\Model\Category;
use App\Model\CartItem;
use App\Model\CartCoupon;
use App\Model\Order;
use App\Model\ItemImages;
use App\Enumeration\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enumeration\OrderStatus;
use Validator;
use Auth;
use DB;
use App\Model\Setting;
use App\Model\User;
use App\Model\MetaBuyer;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        $validatorRules = ([
            'item_id' => 'required|exists:items,id', 
            'quantity' => 'required|numeric|min:1', 
        ]);

        $item = Item::find($request->item_id);
        switch ($item->specification) {
            case '1':
                $validatorRules ['size_id'] = 'required|numeric|exists:sizes,id';
                $validatorRules ['color_id'] = 'required|numeric|exists:colors,id';
                break;
            case '2':
                $validatorRules ['color_id'] = 'required|numeric|exists:colors,id';
                break;
            case '3':
                $validatorRules ['size_id'] = 'required|numeric|exists:sizes,id';
                break;
            case '4':
                break;
            default:
                $validatorRules ['size_id'] = 'required|numeric|exists:sizes,id';
                $validatorRules ['color_id'] = 'required|numeric|exists:colors,id';
                break;
        }
        $validatorRules ['quantity'] = 'required|numeric|min:1';
        Validator::make($request->all(), $validatorRules)->validate();
        $quantity = 0;

        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        }
 
        $cartItem = CartItem::where('user_id', $user_id)
        ->where([ 
            ['item_id', $request->item_id],
            ['size_id', $request->size_id],
            ['color_id', $request->color_id]
        ])->first(); 
        
        $qty_check = (int) $request->quantity;
        if ($cartItem) {
            $qty_check += $cartItem->quantity;
        }
        // check inventory
        $invItem = DB::table('item_inv')
        ->where([ 
            ['item_id', $request->item_id],
            ['itemsize', $request->size_id],
            ['color_id', $request->color_id]
        ])->first();
        if(!$invItem || $invItem->qty < $qty_check) {
            return response()->json(['errors'=>['quantity' => ['Out of stock.']]], 422); 
        } 

        if ($cartItem) {
            $cartItem->quantity += (int) $request->quantity;
            $cartItem->save();
            return response()->json(['success' => true, 'message' => 'Success']);
        } 
        
        $cartItem = CartItem::where('user_id', $user_ip)
        ->where([ 
            ['item_id', $request->item_id],
            ['size_id', $request->size_id],
            ['color_id', $request->color_id]
        ])->first(); 
        if ($cartItem) {
            $cartItem->quantity += (int) $request->quantity;
            $cartItem->save();
            return response()->json(['success' => true, 'message' => 'Success']);
        } 
    
        CartItem::create([
            'user_id' => $user_id,
            'item_id' => $request->item_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
        ]);
        return response()->json(['success' => true, 'message' => 'Success']);
    }

    public function addToCartSuccess() {
        return back()->with('message', 'Added to cart.');
    }

    public function showCart(Request $request) { 
        // return 'have to check coupon';
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        } 
        $data =[];  
        $cartObjs = CartItem::whereIn('user_id', $user)
            ->with('item', 'color','itemsize')
            ->get(); 
        $total = 0.00;

        foreach($cartObjs as $item){
            $qty = $item->quantity;
            $price = $item->item->price;
            $total += $qty * $price; 
        }

        foreach ($cartObjs as $cObj) {

            if($cObj->color_id) {

                $itemimages =   ItemImages::where('item_id',$cObj->item_id)->where('color_id', $cObj->color_id)->orderBy('sort')->get();
                $cObj->item_images = $itemimages;

            } else {

                $itemimages =   ItemImages::where('item_id',$cObj->item_id)->orderBy('sort')->get();
                $cObj->item_images = $itemimages;
                
            }
        }

        $pointExists = \DB::table('point_system_settings')->where('status',1)->first();
        $dollarDiscount = \DB::table('point_dollar_discount')->first();
        $default_img = Setting::where('name', 'default-item-image')->first(); 
        $data['cartItems'] = $cartObjs;
        $data['promoCode'] = $this->getCoupon($user_id, $user);
        $data['total'] = $total;
        $data['default_img'] = $default_img;
        $data['pointExists'] = $pointExists;
        $data['dollarDiscount'] = $dollarDiscount;
         
        return response()->json($data); 
    }
    
    public function updateCartItem(Request $request){ 
        $request->validate([
            'id' => 'required|exists:cart_items,id', 
            'quantity' => 'required|numeric|min:1', 
        ]);
        
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        } 
        
        $cartItem = CartItem::where('id', $request->id)->whereIn('user_id', $user)->first();

        $qty_check = (int) $request->quantity;
        if ($cartItem) {
            $qty_check += $cartItem->quantity;
        }
        // check inventory
        $invItem = DB::table('item_inv')
        ->where([ 
            ['item_id', $cartItem->item_id],
            ['itemsize', $cartItem->size_id],
            ['color_id', $cartItem->color_id]
        ])->first();
        if(!$invItem || $invItem->qty < $qty_check) {
            return response()->json(['errors'=>['quantity' => ['Out of stock.']]], 422); 
        } 
        // this item could be by user_id/user_ip; merge them.
        // if this item is user_id, add all user_ip;
        // if this item is user_ip, find user_id and merge with that.
        if ($cartItem && ($cartItem->user_id == $user_id)) {
            // find user_ip same product;
            $ipCartItem = CartItem::where('item_id', $cartItem->item_id)
                                    ->where('user_id', $user_ip)
                                    ->where('color_id', $cartItem->color_id)
                                    ->where('size_id', $cartItem->size_id)
                                    ->first();
            if ($ipCartItem && ($user_id != $user_ip)) {
                // ip item remove
                $ipCartItem->delete();
            }
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        } else if ($cartItem && ($cartItem->user_id == $user_ip)) {
            $idCartItem = CartItem::where('item_id', $cartItem->item_id)
                                    ->where('user_id', $user_ip)
                                    ->where('color_id', $cartItem->color_id)
                                    ->where('size_id', $cartItem->size_id)
                                    ->first();
            if ($cartItem && ($user_id != $user_ip)) {
                // ip item remove
                $cartItem->delete();
            }
            $idCartItem->quantity = $request->quantity;
            $idCartItem->save();
        }
        return response()->json(200); 
    }
    public function updateCart(Request $request){
        $request->validate([
            'cartItems' => 'required|array', 
            'cartItems.*.id' => 'required|exists:cart_items,id', 
            'cartItems.*.quantity' => 'required|numeric|min:1', 
        ]);

        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
            $user = [$user_ip];
        } else {
            $user = [$user_id, $user_ip];
        } 
    
        foreach ($request->cartItems as $key=>$item) {
            $cartItem = CartItem::where('id', $item['id'])->whereIn('user_id', $user)->first();
            
            $qty_check = (int) $item['quantity'];
            // check inventory
            $invItem = DB::table('item_inv')
            ->where([ 
                ['item_id', $cartItem->item_id],
                ['itemsize', $cartItem->size_id],
                ['color_id', $cartItem->color_id]
            ])->first();
            if(!$invItem || $invItem->qty < $qty_check) {
                return response()->json(['errors'=>['cartItems.'.$key.'.quantity' => ['Out of stock.']]], 422); 
            }
            if ($cartItem && ($cartItem->user_id == $user_id)) {
                // find user_ip same product;
                $ipCartItem = CartItem::where('item_id', $cartItem->item_id)
                                        ->where('user_id', $user_ip)
                                        ->where('color_id', $cartItem->color_id)
                                        ->where('size_id', $cartItem->size_id)
                                        ->first();
                if ($ipCartItem && ($user_id != $user_ip)) {
                    // ip item remove
                    $ipCartItem->delete();
                }
                $cartItem->quantity = $item['quantity'];
                $cartItem->save();
            } else if ($cartItem && ($cartItem->user_id == $user_ip)) {
                $idCartItem = CartItem::where('item_id', $cartItem->item_id)
                                        ->where('user_id', $user_id)
                                        ->where('color_id', $cartItem->color_id)
                                        ->where('size_id', $cartItem->size_id)
                                        ->first();
                if ($cartItem && ($user_id != $user_ip)) {
                    // ip item remove
                    $cartItem->delete();
                }
                $idCartItem->quantity = $item['quantity'];
                $idCartItem->save();
            }
        }
        return response()->json(200); 
    }
    public function deleteCart(Request $request){ 
        $request->validate([
            'id' => 'required|exists:cart_items,id', 
        ]);
        
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        if(!$user_id) {
            $user_id = $user_ip;
        }
        $item = CartItem::find($request->id);

        $cartItem = CartItem::where('item_id', $item->item_id)
                            ->where('color_id', $item->color_id)
                            ->where('size_id', $item->size_id)
                            ->where('user_id', $user_id)
                            ->first();
        if ($cartItem && ($cartItem->user_id == $user_id || $cartItem->user_id == $user_ip)) {
            $cartItem->delete();
        }
        $cartItem = CartItem::where('item_id', $item->item_id)
                            ->where('color_id', $item->color_id)
                            ->where('size_id', $item->size_id)
                            ->where('user_id', $user_ip)
                            ->first();
        if ($cartItem && ($cartItem->user_id == $user_id || $cartItem->user_id == $user_ip)) {
            $cartItem->delete();
        }
        return response()->json(200); 
    }
    
    public function getCoupon($user_id, $user){
        $cartCoupon = CartCoupon::where('user_id', $user_id)
            ->first(); 
        $applicable = true;
        if($cartCoupon) {
            $coupon = \App\Model\Promotion::where('coupon_code', strtoupper(trim($cartCoupon->coupon_code)))->where('status', 1)->first();            
            if (!$coupon) {
                // coupon exist or not.
                $cartCoupon->delete();
                $applicable = false;
            } else if ($coupon->multiple_use == 0) {
                // coupon multiple used or not.
                $previousOrder = Order::where('user_id', $user_id)
                    ->where('status', '!=', OrderStatus::$INIT)
                    ->where('coupon', $coupon->coupon_code)
                    ->first();
                if ($previousOrder) {
                    $cartCoupon->delete();
                    $applicable = false;
                }
            } else if ($coupon->is_permanent == 0) {
                // for permanent coupon check expirity
                $startDate = strtotime($coupon->valid_from);
                $endDate = strtotime($coupon->valid_to);

                $currentTime = time();

                if($currentTime > $startDate && $currentTime < $endDate) {
                    // valid
                } else {
                    // not valid
                    $cartCoupon->delete();
                    $applicable = false;
                }
            }
            
            if ($applicable) {
                $data = $this->cartCouponDiscount($coupon, $user);
                $data['coupon_code'] = $coupon->coupon_code;
                $data['user_id'] = $user_id;
                $oldCartCoupon = CartCoupon::where('user_id', $user_id)
                    ->first(); 
                if ($oldCartCoupon) {
                    $oldCartCoupon->update($data);
                } else {
                    $newCartCoupon = CartCoupon::create($data);
                }
            }
        }
        
        $cartCoupon = CartCoupon::where('user_id', $user_id)
            ->first(); 
        return $cartCoupon;
    }
    public function guard(){
        return Auth::Guard('api');
    }

    public function cartCouponDiscount($coupon = null, $user)
    {
        if (!$coupon || !$user) return null;
        $cartObjs = CartItem::whereIn('user_id', $user)
            ->with('item')
            ->get(); 
        
        $subTotal = 0.00;

        foreach($cartObjs as $item){
            $qty = $item->quantity;
            $price = $item->item->price;
            $subTotal += $qty * $price; 
        }
        $discount = 0;
        $coupon_details = '';
        $free_shipping = 0;
        $discountFlash = 0.00;

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
        $data['discount'] = $discount;
        $data['coupon_details'] = $coupon_details;
        $data['free_shipping'] = $free_shipping;
        
        return $data;
    }
}
