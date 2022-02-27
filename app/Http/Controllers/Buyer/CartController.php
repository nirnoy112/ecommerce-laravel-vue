<?php

namespace App\Http\Controllers\Buyer;

use App\Model\CartItem;
use App\Model\Item;
use App\Model\MetaVendor;
use App\Model\ItemInv;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class CartController extends Controller
{
    public function addToCart(Request $request) {  
        $qty=0;
        $ip = $request->ip();
        $userid=''; 
        if (Auth::check() && Auth::user()->role == Role::$BUYER) {
            $userid = Auth::user()->id;
        }else{
            $userid = $request->ip(); 
        }  
 
        $cartItem = CartItem::where([ 
            ['user_id',$ip],
            ['item_id', $request->itemId],
            ['size_id', $request->size],
            ['color_id', $request->colors]
        ])->orwhere([ 
                ['user_id',$ip],
                ['item_id', $request->itemId],
                ['size_id', $request->size],
                ['color_id', $request->colors]
            ])->first(); 
            
        if ($cartItem) {
            $cartItem->quantity += (int) $request->qty;
            $cartItem->save();
        } else { 
            CartItem::create([
                'user_id' => $userid,
                'item_id' => $request->itemId,
                'color_id' => $request->colors,
                'size_id' => $request->size,
                'quantity' => $request->qty,
            ]);
        }  
        $cartitems =  CartItem::where('user_id',$userid)->orwhere('user_id',$ip)->count();  
        return response()->json(['success' => true, 'message' => 'Success','qty'=>$cartitems]);
    }

    public function addToCartSuccess() {
        return back()->with('message', 'Added to cart.');
    }

    public function showCart(Request $request) { 
        $ip = $request->ip();
        $userid='';
        $data =[];
        if (Auth::check() && Auth::user()->role == Role::$BUYER) {
            $userid = Auth::user()->id;
        }  
        $cartObjs = CartItem::where('user_id', $userid)->orwhere('user_id',$ip)
            ->with('item', 'color','itemsize')
            ->get(); 
        $total=0.00;
        foreach($cartObjs as $item){
            $qty = $item->quantity;
            $price = $item->item->price;
            $total += $qty* $price; 
        }
        $data['cartitems'] =$cartObjs;
        $data['total'] =$total;
        return response()->json(['cartitems'=>$data]); 
    }

    public function updateCart(Request $request) {
        $data = [];
        for($i=0; $i < sizeof($request->ids); $i++) {
            $ci = CartItem::where('id', $request->ids[$i])->first();

            $c = 0;

            if (isset($data[$ci->item->id]))
                $c = $data[$ci->item->id];

            $data[$i]['id'] = $ci->item->id;
            $data[$i]['color'] = $ci->color_id;
            $data[$i]['qty'] = (int) ($request->qty[$i]) + $c;
        }
        foreach ($data as $arr) {
            $item = Item::where('id', $arr['id'])->first();

            if ($item->min_qty > $arr['qty'])
                return response()->json(['success' => false, 'message' => $item->style_no.' minimum order qty is '. $item->min_qty]);

            $itemInventory = ItemInv::where('item_id', $arr['id'])->where('color_id', $arr['color'])->first();

            if (isset($itemInventory) &&  $arr['qty'] > $itemInventory->qty)
                return response()->json(['success' => false, 'message' => 'Item In Stock : '. $itemInventory->qty]);
            
            if (isset($itemInventory) && empty($itemInventory->qty))
                return response()->json(['success' => false, 'message' => 'Item is sold out']);

        }

        for($i=0; $i < sizeof($request->ids); $i++) {
            if ($request->qty[$i] == '0')
                CartItem::where('id', $request->ids[$i])->delete();
            else {
                CartItem::where('id', $request->ids[$i])->update(['quantity' => $request->qty[$i]]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Success']);
    }

    public function updateCartSuccess() {
        return back()->with('message', 'Cart Updated!');
    }

    public function deleteCart(Request $request) {
        CartItem::where('id', $request->id)->delete();
    }

    public function deleteCartAll(Request $request) {
        CartItem::where([])->delete();
    }

    public function productCart(){
        return view('pages.cart');
    }
}