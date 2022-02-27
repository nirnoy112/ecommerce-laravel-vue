<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Meta;
use App\Model\ItemSize;
use App\Model\Item;
use App\Model\ItemReview;
use App\Model\Category;
use App\Enumeration\Role;
use App\Model\Setting;
use App\Model\Color; 
use App\Enumeration\PageEnumeration;
use App\Model\ItemImages;
use App\Model\ItemView;
use App\Model\Size;
use App\Model\ItemCategory;
use App\Model\WishListItem;
use App\Model\VendorImage;
use App\Model\Page;
use App\Model\HomePage;
use App\Model\Notification;  
use App\Model\SocialLinks;
use App\Enumeration\VendorImageType;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // 
    public function HeaderDefaultContent(){ 
        $contents = [];
        $big_logo_path = '';   
        $small_logo_path = '';   
        $big = DB::table('settings')->where('name', 'logo-big')->where('status', 1)->first();
        $small = DB::table('settings')->where('name', 'logo-small')->where('status', 1)->first();

        if ($big){ 
            $big_logo_path = asset($big->value);
        }  
        if ($small){ 
            $small_logo_path = asset($small->value);
        }  

        $contents['logo']= $big_logo_path;
        $contents['small_logo']= $small_logo_path;
        return response()->json(['content'=>$contents],200); 
    } 
    public function FooterDefaultContent(){
        $contents = [];
        $black_logo_path = '';   
        $black = DB::table('settings')->where('name', 'logo-black')->first();
        $socialLinks = SocialLinks::orderBy('created_at', 'desc')->first();
        if ($black){ 
            $black_logo_path = asset($black->value);
        }   
        $contents['logo']= $black_logo_path;
        return response()->json(['content'=>$contents, 'socialLinks' => $socialLinks],200); 
    }

    public function StaticPage($id){

        $content = ''; 

        $static_page_title = '';
        $static_page_meta_title = 'Static Page Of Hologram';
        $static_page_meta_description = 'Hologram Static Page Content.';

        if($id == 1) {

            $static_page_title = 'Home - Hologram';

        } else if($id == 2) {

            $static_page_title = 'About Us - Hologram';

        } else if($id == 3) {

            $static_page_title = 'Contact Us - Hologram';
            
        } else if($id == 4) {

            $static_page_title = 'Privacy Policy - Hologram';
            
        } else if($id == 6) {

            $static_page_title = 'Terms & Conditions - Hologram';
            
        } else if($id == 7) {

            $static_page_title = 'Shipping & Return Policy - Hologram';
            
        } else if($id == 8) {

            $static_page_title = 'Size Chart - Hologram';
            
        } else if($id == 19) {

            $static_page_title = 'FAQ - Hologram';

        } else {

            $static_page_title = 'Hologram - $1.50 Store';
            
        }

        $page = Page::where('page_id', $id)->first(); 

        if ($page) {

            $content = $page->content;

            $metadata = Meta::where('page', $id)->first();

            $static_page_meta_title = $metadata->title;
		    $static_page_meta_description = $metadata->description;

        }
         
        return response()->json(['content'=>$content, 'static_page_title' => $static_page_title, 'static_page_meta_title' => $static_page_meta_title, 'static_page_meta_description' => $static_page_meta_description],200);
    
    }

    public function HomePage(){

        $content = ''; 

        $static_page_title = 'Home - Hologram';
        $static_page_meta_title = 'Home Page Of Hologram';
        $static_page_meta_description = 'Hologram Home Page Content.';

        $metadata = Meta::where('page', 1)->first();
        $static_page_meta_title = $metadata->title;
        $static_page_meta_description = $metadata->description;

        $sectionOne = HomePage::where('section_id',1)->first();
        $sectionThree = HomePage::where('section_id',3)->first();
        $sectionFour = HomePage::where('section_id',4)->first();
        $sectionFive = HomePage::where('section_id',5)->first();

        $latestItems = Item::where('status', 1)
                            ->orderBy('sorting')
                            ->orderBy('activated_at', 'desc')
                            ->with('images','sizes','values','brand')
                            ->limit(6)
                            ->get();
        $content = [
            'sectionOne' => $sectionOne,
            'sectionThree' => $sectionThree,
            'sectionFour' => $sectionFour,
            'sectionFive' => $sectionFive,
            'latestItems' => $latestItems,
        ];                    
         
        return response()->json(['content'=>$content, 'static_page_title' => $static_page_title, 'static_page_meta_title' => $static_page_meta_title, 'static_page_meta_description' => $static_page_meta_description],200);
    
    }
     
    public function HomePageDefaultContent(){ 
        $HomeMainBanner = VendorImage::where('type', VendorImageType::$MAIN_BANNER)
            ->where('status', 1)
            ->orderBy('sort')
            ->get(); 
        $ourpicks = VendorImage::where('type', VendorImageType::$SECTION_TWO_BANNER)
            ->where('status', 1)
            ->orderBy('sort')
            ->get();   
        $aboutus = Page::where('page_id', PageEnumeration::$ABOUT_US)->first();
        $custom_section = Page::where('page_id', PageEnumeration::$HOME_PAGE_CUSTOM_SECTION)->first();
        $topnotification = Setting::where('name', 'top_notification')->first(); 
        return response()->json(['mainslider' => $HomeMainBanner, 'ourpicks' => $ourpicks, 'aboutus' => $aboutus, 'topnotification' => $topnotification, 'custom_section' => $custom_section], 200);
    }

    public function SearchBlogPost( ){ 
        $keyword = \Request::get('s'); 
        if($keyword != NULL){
            $items = Item::with('images')
                    ->where("name","LIKE","%$keyword%")
                    ->orWhere("style_no","LIKE","%$keyword%") 
                    ->orWhere("details","LIKE","%$keyword%")  
                    ->get();
                    return response()->json(['items_count' => count($items), 'items' => $items], 200);
        }else{
            return $this->ProductPage();
        }
    }
    public function homenewin(){
        $newArrivalItems = Item::where('status', 1)
            ->orderBy('activated_at', 'desc')
            ->with('images','brand')
            ->limit(10)
            ->get();

        return response()->json(['newin'=>$newArrivalItems,],200); 
    }
    public function CategoryPage($catlist){  
        $catlist = explode(',', $catlist);  
        $parentCategory='';
        $query = Item::query();
        if(isset($catlist[0])){
            $parentCategory = Category::where('slug',$catlist[0])->first(); 
            $item_category = ItemCategory::where('default_parent_category',$parentCategory->id)->select('item_id')->get();
            $item_id=[];
            foreach($item_category as $cat){
                $item_id[]=$cat->item_id;
            } 
        }
        $items = $query->with(  'images' )->where('status',1)->get();
        
        return response()->json(['items'=>$items],200);
    }
    public function ProductPage(){ 
        $query = Item::query();
        $items = $query->with(  'images' )->where('status',1)->orderBy('sorting','asc')->get();  
        return response()->json(['items_count' => count($items), 'items' => $items], 200);
    }
    public function ProductSingleInfo(Request $request, $slug){   
        $product_page_title = 'Hologram - $1.50 Store';
        $product_meta_title = 'Single product details information';
        $product_meta_description = 'Hologram is a retail cosmetics web store where you can purchase any cosmetics product you need within $1.50 expense.';
        
        $userid=''; 

        if (Auth::check() && Auth::user()->role == Role::$BUYER) {$userid = Auth::user()->id;}else{$userid = $request->ip(); }   

        $slugCheck = Item::where('slug', $slug)->with('categories', 'images', 'brand', 'values' )->first(); 
        if (!$slugCheck) {
            return response()->json(['notfound'=> '404' ], 200);
        }
        // setReview
        $totalReviews = ItemReview::where('item_id', $slugCheck->id)->count();
        $rate = ItemReview::where('item_id', $slugCheck->id)->avg('rate');
        $rate = number_format((float)$rate, 2, '.', '');
        $slugCheck->totalReviews = $totalReviews;
        $slugCheck->rate = $rate;


        $product_page_title = ' - Hologram';
        $product_meta_title = ' product details information';
        $product_meta_description = ' from Hologram retail cosmetics web store.';
        if($slugCheck) { 
            $product_page_title = $slugCheck->style_no . ' - Hologram';
            $product_meta_title = $slugCheck->name . ' product details information';
            $product_meta_description = 'Purchase ' . $slugCheck->style_no . ': ' . $slugCheck->name . ' from Hologram retail cosmetics web store.'; 
        }

        $firstcolor =   ItemImages::where('sort',1)->where('item_id',$slugCheck->id)->first();
        if(!empty($firstcolor)){  
            $firstcolor =   Color::where('id',$firstcolor->color_id)->first();
        }else{
            $firstcolor = null;
        }
         
        // $itemsize =     DB::table('item_size')
        //                 ->join('sizes','item_size.size_id','sizes.id')
        //                 ->where('item_size.item_id',$slugCheck->id)
        //                 ->get();

        $itemsize =     DB::table('item_inv')
                        ->join('sizes','item_inv.itemsize','sizes.id')
                        ->where('item_inv.item_id',$slugCheck->id)
                        ->orderBy('item_inv.sort')
                        ->get();

        $sizes =     DB::table('item_inv')
                        ->join('sizes','item_inv.itemsize','sizes.id')
                        ->where('item_inv.item_id',$slugCheck->id)
                        ->orderBy('item_inv.sort')
                        ->get();

        // $itemcolor =     DB::table('color_item')
        //                 ->join('colors','color_item.color_id','colors.id')
        //                 ->where('color_item.item_id',$slugCheck->id)
        //                 ->get();
        
        $itemcolor =     DB::table('item_inv')
                        ->join('colors','item_inv.color_id','colors.id')
                        ->where('item_inv.item_id',$slugCheck->id)
                        ->groupBy('item_inv.color_id')
                        ->orderBy('item_inv.sort')
                        ->get();

        // if(!empty($firstcolor)){
        //     $itemimages =   ItemImages::where('item_id',$slugCheck->id)->where('color_id',$firstcolor->id)->orderBy('sort')->get();
        // }else{ 
        //     $itemimages =   ItemImages::where('item_id',$slugCheck->id)->orderBy('sort')->get();
        // }
        
        $itemimages =   ItemImages::where('item_id',$slugCheck->id)->orderBy('sort')->get();

        $relatedItem = array();

        $sizechart = Page::where('page_id', PageEnumeration::$SIZE_GUIDE)->first();
        $returnpage = Page::where('page_id', PageEnumeration::$RETURN_INFO)->first();
        $topnotification = Setting::where('name', 'top_notification')->first(); 

        $ItemCategory = ItemCategory::where('item_id',$slugCheck->id)->first();
        $categoryId = $ItemCategory->default_parent_category;
        $itemsQuery = Item::query();
        $itemsQuery->join('item_categories', 'items.id', '=', 'item_categories.item_id')  
	        		   ->select('items.*', 'item_categories.item_id')
	        		   ->with('categories', 'images', 'brand', 'values' )
                       ->where('status', 1) 
                       ->where('items.id', '<>', $slugCheck->id)
                       ->groupby('item_categories.item_id')
                       ->limit(8);
                       $itemsQuery->where('item_categories.default_parent_category', $categoryId);
        $relatedItem = $itemsQuery->get();
        $i=0;
        foreach($relatedItem as $item){
			$relatedItem[$i]['sizes'] =  \DB::table('item_size')
							->join('sizes','sizes.id','item_size.size_id')
							->where('item_size.item_id',$item->id) 
							->get();
			$i++;
        }
        

        $wishlist  = WishListItem::where([ 
                        ['user_id',$userid],
                        ['item_id', $slugCheck->id] 
                    ])->first(); 
        
        $brand = '';
        $brand = \DB::table('brands')->where('id',$slugCheck->brand_id)->first(); 
        return response()->json([
                    'product' => $slugCheck, 
                    'firstcolor' => $firstcolor, 
                    'colors' => $itemcolor, 
                    'brand' => $brand, 
                    'itemsize' => $itemsize, 
                    'sizes' => $sizes, 
                    'sizechart' => $sizechart, 
                    'images' => $itemimages, 
                    'returns' => $returnpage, 
                    'wishlist' => $wishlist, 
                    'relatedItem' => $relatedItem, 
                    'default_img' => (count($itemimages) > 0) ? $itemimages[0]: null,
                    'topnotification' => $topnotification,
                    'product_page_title' => $product_page_title,
                    'product_meta_title' => $product_meta_title,
                    'product_meta_description' => $product_meta_description
                    ]
                    , 200); 
    }
    public function productView(Request $request, $slug){
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();
        // if(!$user_id) {
        //     $user_id = $user_ip;
        // }

        $item = Item::where('slug', $slug)->first();
        if ($item) {
            ItemView::create([
                'item_id' => $item->id, 
                'user_id' => $user_id, 
                'ip' => $user_ip
            ]);
            return response()->json(200);
        }
        return response()->json(200); 
    }
    public function recentlyViewed(Request $request){
        $user_id = $this->guard()->id();
        $user_ip = $request->ip();

        $itemIds = ItemView::where('user_id', $user_id)->orWhere('ip', $user_ip)->take(8)->orderBy('created_at', 'desc')->groupBy('item_id')->get()->pluck('item_id');
        
        $recentlyViewed = Item::whereIn('id', $itemIds)->with('categories', 'images', 'sizes', 'brand', 'values' )->get();
        return response()->json([
            'recentlyViewed' => $recentlyViewed, 
            ], 200); 
    }

    public function productValues(){
        $productValues = \App\Model\ItemValue::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return response()->json(['productValues' => $productValues],200); 
    }

    public function productBrands(){
        $productBrands = \App\Model\Brand::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return response()->json(['productBrands' => $productBrands],200); 
    }
    public function guard(){
        return Auth::Guard('api');
    }
}
