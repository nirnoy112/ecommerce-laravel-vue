<?php

namespace App\Http\Controllers\Api;

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
use App\Model\AdminShipMethod;
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

class ItemController extends Controller
{
    public function index() {

    	$itemsQuery = Item::query();
        $itemsQuery->where('status', 1)->with('categories', 'images');

        $itemsQuery->orderBy('activated_at', 'asc');

        $items = $itemsQuery->paginate(40);

        return response()->json(['items_count' => count($items), 'items' => $items], 200);

    }

    public function searchItems(Request $request) {  
		 
		//return response()->json(['request' => $request->route]);
		$category = Category::where('slug',$request->route)->first(); 
		$default_img = Setting::where('name', 'default-item-image')->first(); 

		$category_page_title = 'Hologram - $1.50 Store';
		$category_meta_title = 'List of Hologram available products';
		$category_meta_description = '';

		if(!empty($category)) {  
			$currentCategory = [];
			$currentCategory['current'] = null;
			$currentCategory['parent'] = null;
			$currentCategory['sub'] = null; 
			$categoryId = $category->id; 
			$category_page_title = $category->name . ' - Hologram'; 
			$metadata = Meta::where('category', $category->id)->first();
			$category_meta_title = '';
			$category_meta_description = '';
			if(!empty($metadata)){ 
				$category_meta_title = $metadata->title;
				$category_meta_description = $metadata->description;
			} 
			$category = Category::where('id', $categoryId)->first();  
			$currentCategory['current'] = $category;
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
						->with('categories', 'images','brand', 'values')
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
				if ($request->value_id) {  
					$itemsQuery->join('item_item_value', 'items.id', '=', 'item_item_value.item_id')  
					->where('item_item_value.item_value_id', $request->value_id);
				}
				if ($request->brand_id) {  
					$itemsQuery->where('brand_id', $request->brand_id);
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

			return response()->json(['items_count' => count($items), 'items' => $items, 'currentCategory'=>$currentCategory,'category' => $category, 'default_img' =>$default_img, 'category_page_title' => $category_page_title, 'category_meta_title' => $category_meta_title, 'category_meta_description' => $category_meta_description], 200);
				
		} else { 
			if($request->search_text) {
				$itemsQuery = Item::query(); 
					$itemsQuery->where('status', 1)->with('categories', 'images', 'brand', 'values'); 
						$data = explode(',', $request->search_text); 
						$itemsQuery->where(function ( $q) use ($data, $request){ 
							foreach ($data as $value){ 
								$q->orWhere('style_no', 'like', '%' . ltrim($value, ' ') . '%'); 
							} 
							$q->orWhere('details', 'like', '%' . $request->search_text . '%'); 
							$q->orWhere('name', 'like', '%' . $request->search_text . '%'); 
					});  
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
					
				if ($request->value_id) {  
					$itemsQuery->join('item_item_value', 'items.id', '=', 'item_item_value.item_id')  
					->where('item_item_value.item_value_id', $request->value_id);
				}
				if ($request->brand_id) {  
					$itemsQuery->where('brand_id', $request->brand_id);
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
					return response()->json(['items_count' => count($items), 'items' => $items, 'category' => null, 'default_img' =>$default_img, 'category_page_title' => $category_page_title, 'category_meta_title' => $category_meta_title, 'category_meta_description' => $category_meta_description ], 200);

			}else{
				return response()->json(['notfound'=> '404' ], 200);
			} 
		}
    }

    public function searchInSite(Request $request) {  
		$request->validate([
            'search_text' => 'required|string|min:4',  
		]);
		$itemsQuery = Item::query(); 
		$itemsQuery->where('status', 1)->with('images', 'brand'); 
		$itemsQuery->where(function ( $q) use ($request){ 
			$q->orWhere('style_no', 'like', '%' . $request->search_text . '%'); 
			$q->orWhere('details', 'like', '%' . $request->search_text . '%'); 
			$q->orWhere('name', 'like', '%' . $request->search_text . '%'); 
		});
		$items = $itemsQuery->take(8)->get();

		$categoriesQuery = Category::query(); 
		$categoriesQuery->where('status', 1); 
		$categoriesQuery->where(function ( $q) use ($request){ 
			$q->orWhere('name', 'like', '%' . $request->search_text . '%'); 
			$q->orWhere('slug', 'like', '%' . $request->search_text . '%'); 
		});
		$categories = $categoriesQuery->take(10)->get();

		return response()->json(['items' => $items, 'categories' => $categories ], 200);
    }

    public function GetAllSizes(){
	$sizes = Size::all();
	return response()->json(['sizes' => $sizes], 200);
    }
    public function GetAllColors(){
	$colorsall = Color::query();
	$colorsall->join('color_item', 'colors.id', '=', 'color_item.color_id')->groupby('colors.id'); 
	$colors = $colorsall->get();   
	return response()->json(['colors' => $colors], 200);
    }
    public function getAllCountry(){
		$countries = Country::orderBy('name')->get(); 
		return response()->json([ 'countries' => $countries ], 200);
    }
    public function getAllStates(){
		$usStates = State::where('country_id', 1)->orderBy('name')->get()->toArray();
	  	$caStates = State::where('country_id', 2)->orderBy('name')->get()->toArray();
	  	$states = State::orderBy('name')->get()->toArray();
	  	return response()->json([ 'caStates' => $caStates, 'usStates' => $usStates, 'states' => $states], 200);
	}
    public function getAllShippingMethods(){
        $shippingMethods = AdminShipMethod::with('courier')->get();
	  	return response()->json([ 'shippingMethods' => $shippingMethods], 200);
	}

	public function getimages(Request $request){ 
		
		$itemImages[0] =   ItemImages::where('item_id',$request->itemId)->orderBy('sort')->first();

		if($request->color > 0){ 

			$itemImages =   ItemImages::where('item_id',$request->itemId)->where('color_id',$request->color)->orderBy('sort')->get();

			if(count($itemImages) == 0) {

				$itemImages[0] =   ItemImages::where('item_id',$request->itemId)->orderBy('sort')->first(); 

			}

		}
        
		return response()->json([  'images' => $itemImages ], 200);
	}

}
