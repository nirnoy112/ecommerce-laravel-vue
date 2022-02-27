<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Model\Item;
use App\Model\Category;
use DateTime;
use App\Model\OrderItem;
use App\Model\OrderTotal;
use App\Model\CartTotal;
use App\Model\Order;
use DB;

class ItemStatisticsController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent', 0)->orderBy('sort')->orderBy('name')->get();
        
        return view('admin.dashboard.statistics.index',compact('categories'))->with('page_title', 'Item Statistics');
    }

     public function filter(Request $request)
    {
        $query = Item::query();

        $query = $query->with('images', 'orders', 'orders.order', 'carts');

        if($request->type == 'item_activation'){
            if(!empty($request->period)){
                $query = $this->item_activation($request->period , $query);
            }else{
                $start_date = date("Y-m-d", strtotime($request->start_date));
                $end_date = date("Y-m-d", strtotime($request->end_date));
                $query = $this->item_activation_period($start_date,$end_date, $query);
            }
        }
        
        if($request->type == 'view'){
            if(!empty($request->period)){
                $query = $this->view($request->period , $query);
            }else{
                $start_date = date("Y-m-d", strtotime($request->start_date));
                $end_date = date("Y-m-d", strtotime($request->end_date));
                $query = $this->view_period($start_date,$end_date, $query);
            }
        }

        if($request->type == 'cart'){
            if(!empty($request->period)){
                $query = $this->cart($request->period , $query);
            }else{
                $start_date = date("Y-m-d", strtotime($request->start_date));
                $end_date = date("Y-m-d", strtotime($request->end_date));
                $query = $this->cart_period($start_date,$end_date, $query);
            }
        }

        if($request->type == 'order'){
            if(!empty($request->period)){
                $query = $this->order($request->period , $query);
            }else{
                $start_date = date("Y-m-d", strtotime($request->start_date));
                $end_date = date("Y-m-d", strtotime($request->end_date));
                $query = $this->order_period($start_date,$end_date, $query);
            }
        }

        if(!($request->status == 'all')){
            $query->where('status', $request->status);
        }

        if(!empty($request->style_no)){
            $query->where('style_no', $request->style_no);
        }

        if( $request->category != 'all' ){
            $query->where('default_parent_category', $request->category);
        }
        $query = $this->sort_by( $request->sort , $query);

        $items = $query->paginate(15);
        $orderStatus = [OrderStatus::$INIT, OrderStatus::$NEW_ORDER, OrderStatus::$CONFIRM_ORDER, OrderStatus::$PARTIALLY_SHIPPED_ORDER, OrderStatus::$FULLY_SHIPPED_ORDER, OrderStatus::$BACK_ORDER];
       
        foreach ($items as $item) {
            // $total_order_qty = 0;
            // $total_amount = 0;
            // foreach($item->orders as $itemOrder) {
            //     if($itemOrder->order && in_array($itemOrder->order->status, $orderStatus)) {
            //         $total_order_qty += $itemOrder->total_qty;
            //         $total_amount += $itemOrder->amount; 
            //     }   
            // }        
            // $item->total_order_qty = $total_order_qty;            
            // $item->total_amount = $total_amount;            
            $item->total_in_cart = $item->carts->sum('quantity');            
        }        

        $paginationView = $items->links('others.pagination');
        $paginationView = trim(preg_replace('/\r\n/', ' ', $paginationView));

        return ['items' => $items->toArray(), 'pagination' => $paginationView];
    }

    protected function sort_by( $sort , $query){
        $query->withCount(['orders as total_amount' => function($queryInner) {
            $queryInner->has('order');
            $queryInner->select(DB::raw('sum(order_items.amount)'));
        }]);
        $query->withCount(['orders as total_order_qty' => function($queryInner) {
            $queryInner->has('order');
            $queryInner->select(DB::raw('sum(order_items.total_qty)'));
        }]);
        $query->withCount(['carts as carts_sum' => function($queryInner) {
            $queryInner->select(DB::raw('sum(cart_items.quantity)'));
        }]);

        if($sort == 0){
            return $query->orderBy('total_amount', 'desc');
        }else if($sort == 1){
            return $query->orderBy('total_amount', 'asc');
        }else if($sort == 2){
            return $query->orderBy('total_order_qty', 'desc');
        }else if($sort == 3){
            return $query->orderBy('total_order_qty', 'asc');
        }else if($sort == 4){
            return $query->orderBy('activated_at','desc');
        }else if($sort == 5){
            return $query->orderBy('activated_at','asc');
        }else if($sort == 6){
            return $query->orderBy('view','desc');
        }else if($sort == 7){
            return $query->orderBy('view','asc');
        }else if($sort == 8){
            return $query->orderBy('carts_sum', 'desc');
        }else if($sort == 9){
            return $query->orderBy('carts_sum', 'asc');
        }
    }

    protected function item_activation($period , $query){
        if($period == 'yesterday'){
          return $query->whereDate('activated_at', Carbon::now()->subDays(1));
        }else if($period == 'this_week'){
          return $query->whereBetween('activated_at',[Carbon::parse('last monday')->startOfDay(),Carbon::now()->endOfDay()]);
        }else if($period == 'this_month'){
            return $query->whereBetween('activated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
        }else if($period == 'this_year'){
            return $query->whereYear('activated_at', Carbon::now()->year);
        }else if($period == 'last_week'){
            return $query->whereBetween('activated_at', [Carbon::now()->subWeek()->startOfWeek(),Carbon::now()->subWeek()->endOfWeek()]);
        }else if($period == 'last_month'){
            return $query->whereMonth('activated_at', Carbon::now()->month-1);
        }else if($period == 'last_year'){
            return $query->whereYear('activated_at', Carbon::now()->year-1);
        }else if($period == 'last_7_days'){
          return $query->where('activated_at',  '>' , Carbon::now()->subDays(7)->toDateTimeString());
        }else if($period == 'last_30_days'){
            return $query->where('activated_at',  '>' , Carbon::now()->subDays(30)->toDateTimeString());
        }else if($period == 'last_90_days'){
            return $query->where('activated_at',  '>' , Carbon::now()->subDays(90)->toDateTimeString());
        }else if($period == 'last_365_days'){
            return $query->where('activated_at',  '>' , Carbon::now()->subDays(365)->toDateTimeString());
        }
    }

    protected function item_activation_period($start_date, $end_date , $query){
       if(empty($start_date) && empty($end_date)){
           return $query;
       }else{
           $start_date = $start_date ? $start_date." 00:00:00": Carbon::now();
           $end_date = $end_date ? $end_date." 23:59:59": Carbon::now();
           return $query->whereBetween('activated_at', [$start_date, $end_date]);
       }
    }

    protected function view($period , $query){
        if($period == 'yesterday'){
            return $query->whereDate('v_created_at', Carbon::now()->subDays(1));
        }else if($period == 'this_week'){
            return $query->whereBetween('v_created_at',[Carbon::parse('last monday')->startOfDay(),Carbon::now()->endOfDay()]);
        }else if($period == 'this_month'){
            return $query->whereBetween('v_created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
        }else if($period == 'this_year'){
            return $query->whereYear('v_created_at', Carbon::now()->year);
        }else if($period == 'last_week'){
            return $query->whereBetween('v_created_at', [Carbon::now()->subWeek()->startOfWeek(),Carbon::now()->subWeek()->endOfWeek()]);
        }else if($period == 'last_month'){
            return $query->whereMonth('v_created_at', Carbon::now()->month-1);
        }else if($period == 'last_year'){
            return $query->whereYear('v_created_at', Carbon::now()->year-1);
        }else if($period == 'last_7_days'){
            return $query->where('v_created_at',  '>' , Carbon::now()->subDays(7)->toDateTimeString());
        }else if($period == 'last_30_days'){
            return $query->where('v_created_at',  '>' , Carbon::now()->subDays(30)->toDateTimeString());
        }else if($period == 'last_90_days'){
            return $query->where('v_created_at',  '>' , Carbon::now()->subDays(90)->toDateTimeString());
        }else if($period == 'last_365_days'){
            return $query->where('v_created_at',  '>' , Carbon::now()->subDays(365)->toDateTimeString());
        }
    }

    protected function view_period($start_date, $end_date , $query){
       if(empty($start_date) && empty($end_date)){
           return $query;
       }else{
           $start_date = $start_date ? $start_date." 00:00:00": Carbon::now();
           $end_date = $end_date ? $end_date." 23:59:59": Carbon::now();
           return $query->whereBetween('v_created_at', [$start_date, $end_date]);
       }
    }

    protected function cart($period , $query){
        if($period == 'yesterday'){
            return $query->whereDate('c_created_at', Carbon::now()->subDays(1));
        }else if($period == 'this_week'){
           return $query->whereBetween('c_created_at',[Carbon::parse('last monday')->startOfDay(),Carbon::now()->endOfDay()]);
        }else if($period == 'this_month'){
           return $query->whereBetween('c_created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
        }else if($period == 'this_year'){
           return $query->whereYear('c_created_at', Carbon::now()->year);
        }else if($period == 'last_week'){
           return $query->whereBetween('c_created_at', [Carbon::now()->subWeek()->startOfWeek(),Carbon::now()->subWeek()->endOfWeek()]);
        }else if($period == 'last_month'){
           return $query->whereMonth('c_created_at', Carbon::now()->month-1);
        }else if($period == 'last_year'){
           return $query->whereYear('c_created_at', Carbon::now()->year-1);
        }else if($period == 'last_7_days'){
           return $query->where('c_created_at',  '>' , Carbon::now()->subDays(7)->toDateTimeString());
        }else if($period == 'last_30_days'){
           return $query->where('c_created_at',  '>' , Carbon::now()->subDays(30)->toDateTimeString());
        }else if($period == 'last_90_days'){
           return $query->where('c_created_at',  '>' , Carbon::now()->subDays(90)->toDateTimeString());
        }else if($period == 'last_365_days'){
           return $query->where('c_created_at',  '>' , Carbon::now()->subDays(365)->toDateTimeString());
        }
    }

    protected function cart_period($start_date, $end_date , $query){
       if(empty($start_date) && empty($end_date)){
           return $query;
       }else{
           $start_date = $start_date ? $start_date." 00:00:00": Carbon::now();
           $end_date = $end_date ? $end_date." 23:59:59": Carbon::now();
           return $query->whereBetween('c_created_at', [$start_date, $end_date]);
       }
    }

    protected function order($period , $query){
        if($period == 'yesterday'){
            return $query->whereDate('o_created_at', Carbon::now()->subDays(1));
        }else if($period == 'this_week'){
           return $query->whereBetween('o_created_at',[Carbon::parse('last monday')->startOfDay(),Carbon::now()->endOfDay()]);
        }else if($period == 'this_month'){
           return $query->whereBetween('o_created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
        }else if($period == 'this_year'){
           return $query->whereYear('o_created_at', Carbon::now()->year);
        }else if($period == 'last_week'){
           return $query->whereBetween('o_created_at', [Carbon::now()->subWeek()->startOfWeek(),Carbon::now()->subWeek()->endOfWeek()]);
        }else if($period == 'last_month'){
           return $query->whereMonth('o_created_at', Carbon::now()->month-1);
        }else if($period == 'last_year'){
           return $query->whereYear('o_created_at', Carbon::now()->year-1);
        }else if($period == 'last_7_days'){
           return $query->where('o_created_at',  '>' , Carbon::now()->subDays(7)->toDateTimeString());
        }else if($period == 'last_30_days'){
           return $query->where('o_created_at',  '>' , Carbon::now()->subDays(30)->toDateTimeString());
        }else if($period == 'last_90_days'){
           return $query->where('o_created_at',  '>' , Carbon::now()->subDays(90)->toDateTimeString());
        }else if($period == 'last_365_days'){
           return $query->where('o_created_at',  '>' , Carbon::now()->subDays(365)->toDateTimeString());
        }
    }

    protected function order_period($start_date, $end_date , $query){
       if(empty($start_date) && empty($end_date)){
           return $query;
       }else{
           $start_date = $start_date ? $start_date." 00:00:00": Carbon::now();
           $end_date = $end_date ? $end_date." 23:59:59": Carbon::now();
          return $query->whereBetween('o_created_at', [$start_date, $end_date]);
       }
    }

    function get_quantity_of_color_product(Request $request){
        $data = OrderItem::with('order')->has('order')->where('item_id',$request->item_id)->groupBy('color')->get();
        $items = [];
        $OrderItems =[];
        foreach ($data as $key => $value) {
            $total_qty = 0;
            $amount = 0;
            $OrderItems[$value->color] = OrderItem::with('order')->has('order')->where('color', $value->color)
                                        ->where('item_id',$request->item_id)->get();

            foreach ($OrderItems[$value->color] as $item) {
                $total_qty +=  $item->total_qty;
                $amount +=  $item->amount;
            }

            $items [] = [
                'color' => $OrderItems[$value->color][0]->color,
                'total_qty' => $total_qty,
                'amount' =>  sprintf('%0.2f', $amount)
            ];
        }
        return $items;
    }

    public function stylenoSearch(Request $request){

        $search = $request->search;
        $items = Item::where('style_no', 'like', '%' .$search . '%')->get();
        $total = $items->count();
        $response = [];
        foreach($items as $item){
            $response[] = ["value"=>$item->style_no , 'total'=>$total];
        }
        echo json_encode($response);
    }
}