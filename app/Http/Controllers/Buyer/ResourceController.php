<?php

namespace App\Http\Controllers\Buyer;

use App\Model\Meta;
use App\Enumeration\Role;
use App\Model\Category;
use App\Model\Item;
use App\Model\ItemCategory;
use App\Model\ItemImages;
use App\Model\Setting;
use App\Model\MadeInCountry;
use App\Model\WishListItem;
use App\Model\User;
use App\Model\State;
use App\Model\Country;
use Illuminate\Http\Request;
use App\Model\Color; 
use App\Model\Size;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Exception\NotReadableException;
use Uuid;
use Image;
use File;
use ImageOptimizer;

use Carbon\Carbon;

class ResourceController extends Controller {

    public function index() {

        return response()->json(['success' => true, 'message' => 'Buyer Resource Controller.'], 200);

    }

    public function searchItems(Request $request) { 
        $currentCategory = [];
        $currentCategory['current'] = null;
        $currentCategory['parent'] = null;
        $currentCategory['sub'] = null; 
        $category = Category::where('slug',$request->route)->first(); 
        $default_img = Setting::where('name', 'default-item-image')->first(); 
        $currentCategory['current'] = $category;
        $category_page_title = 'Miss & More - $1.50 Store';
        $category_meta_title = 'List of Miss & More available products';
        $category_meta_description = '';
    
        if(!empty($category)) { 
    
            $categoryId = $category->id;
    
            $category_page_title = $category->name . ' - Miss & More';
            
            $metadata = Meta::where('category', $category->id)->first();
            $category_meta_title = '';
            $category_meta_description = '';
            
            if(!empty($metadata)) { 

                $category_meta_title = $metadata->title;
                $category_meta_description = $metadata->description;

            } 

            $category = Category::where('id', $categoryId)->first();  

            $categoryLevel = 1; 
            if ($category->parent != 0) { 
                if($category->parentCategory->parent == 0) { 
                    $categoryLevel = 2; 
                } else { 
                    $categoryLevel = 3; 
                } 
            }

            $category['level'] = $categoryLevel;

            $itemsQuery = Item::query();
                
            $itemsQuery->join('item_categories', 'items.id', '=', 'item_categories.item_id')
                        ->select('items.*', 'item_categories.item_id')
                        ->with('categories', 'images','brand')
                        ->where('status', 1)
                        ->groupby('item_categories.item_id');

            
            if($categoryLevel == 1) { 
                $itemsQuery->where('item_categories.default_parent_category', $categoryId); 
            } else if($categoryLevel == 2) {  
                $subcategory = Category::where('id', $category->parent)->first(); 
                $currentCategory['parent'] = $subcategory;
                $itemsQuery->where('item_categories.default_second_category', $categoryId);

            } else if($categoryLevel == 3) {
                $subcategory = Category::where('id', $category->parent)->first(); 
                $third = Category::where('id', $subcategory->parent)->first(); 
                $currentCategory['sub'] = $subcategory;
                $currentCategory['parent'] = $third;
                $itemsQuery->where('item_categories.default_third_category', $categoryId);

            }

            if ($request->price) { 
                if($request->price['first'] != null){
                    $itemsQuery->where('price', '>=', $request->price['first']);
                } 
                if($request->price['last'] != null){
                    $itemsQuery->where('price', '<=', $request->price['last']);
                } 
            }
            if ($request->size) {  
                $itemsQuery->join('item_size', 'items.id', '=', 'item_size.item_id') 
                ->where('item_size.size_id', $request->size);
            }
            if ($request->color) {  
                $itemsQuery->join('color_item', 'items.id', '=', 'color_item.item_id')  
                ->where('color_item.color_id', $request->color);
            }
                 
    
            if ($request->search_text) { 
                $data = explode(',', $request->search_text); 
                $itemsQuery->where(function ( $q) use ($data, $request){
                    
                    foreach ($data as $value){

                        $q->orWhere('style_no', 'like', '%' . ltrim($value, ' ') . '%');

                    } 
                    $q->orWhere('details', 'like', '%' . $request->search_text . '%');
                
                    $q->orWhere('name', 'like', '%' . $request->search_text . '%');
                    
                }); 
            }
                
            $itemsQuery->orderBy($request->order_by, $request->sort_by);
    
            $items = $itemsQuery->paginate($request->PerPage);

            $i=0;
            foreach($items as $item){

                $items[$i]['sizes'] =  \DB::table('item_size')
                                ->join('sizes','sizes.id','item_size.size_id')
                                ->where('item_size.item_id',$item->id) 
                                ->get();

                $i++;

            }
    
            return response()->json(['items_count' => count($items), 'items' => $items,'currentCategory'=>$currentCategory, 'category' => $category, 'default_img' =>$default_img, 'category_page_title' => $category_page_title, 'category_meta_title' => $category_meta_title, 'category_meta_description' => $category_meta_description], 200);
                
        } else {
    
            $itemsQuery = Item::query();
    
            $itemsQuery->where('status', 1)->with('categories', 'images');
    
            if($request->search_text) {
    
                $data = explode(',', $request->search_text);
    
                $itemsQuery->where(function ( $q) use ($data, $request){
                        
                    foreach ($data as $value){
    
                        $q->orWhere('style_no', 'like', '%' . ltrim($value, ' ') . '%');
    
                    }
                    
                    $q->orWhere('details', 'like', '%' . $request->search_text . '%');
                    
                    $q->orWhere('name', 'like', '%' . $request->search_text . '%');
                        
                });
    
            }

            if ($request->price) { 

                if($request->price['first'] != null){
                    $itemsQuery->where('price', '>=', $request->price['first']);
                } 
                if($request->price['last'] != null){
                    $itemsQuery->where('price', '<=', $request->price['last']);
                } 

            }

            if ($request->size) {  
                $itemsQuery->join('item_size', 'items.id', '=', 'item_size.item_id') 
                ->where('item_size.size_id', $request->size);
            }

            if ($request->color) {  
                $itemsQuery->join('color_item', 'items.id', '=', 'color_item.item_id')  
                ->where('color_item.color_id', $request->color);
            }
                
            $itemsQuery->orderBy($request->order_by, $request->sort_by);

            $items = $itemsQuery->paginate($request->PerPage);
            
            return response()->json(['items_count' => count($items), 'items' => $items, 'category' => null, 'default_img' =>$default_img, 'category_page_title' => $category_page_title, 'category_meta_title' => $category_meta_title, 'category_meta_description' => $category_meta_description ], 200);
    
        } 
            
    }


}