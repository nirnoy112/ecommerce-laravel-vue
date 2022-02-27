<?php

namespace App\Http\Controllers\Api\Admin;

use Uuid;
use Validator;
use App\Model\Meta;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;

class CategoryController extends Controller
{
    public function index() {
        $categories = [];
        $metadata = []; 
        $mname='';
        $mdesc=' ';
        $categoriesCollection = Category::orderBy('sort')->orderBy('name')->get(); 
        foreach($categoriesCollection as $cc) {
        $metadata = Meta::where('category',$cc->id)->first(); 
            if(!empty($metadata)){$mname=$metadata->title;$mdesc=$metadata->description;}  
            if ($cc->parent == 0) { 
                $data = [
                    'id' => $cc->id,
                    'name' => $cc->name,
                    'meta_title' => $mname,
                    'meta_desc' => $mdesc
                ]; 
                $subCategories = [];
                foreach($categoriesCollection as $item) { 
                    $metadata2 =  Meta::where('category',$item->id)->first(); 
                    if(!empty($metadata2)){$mname=$metadata2->title;$mdesc=$metadata2->description;}  
                    if ($item->parent == $cc->id) {
                        $data2 = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'meta_title' => $mname,
                            'meta_desc' => $mdesc
                        ];
                        $data3 = [];
                        foreach($categoriesCollection as $item2) {
                            $metadata3 =Meta::where('category',$item2->id)->first();
                            if(!empty($metadata3)){$mname=$metadata3->title;$mdesc=$metadata3->description;}  

                            if ($item2->parent == $item->id) {
                                $data3[] = [
                                    'id' => $item2->id,
                                    'name' => $item2->name,
                                    'meta_title' => $mname,
                                    'meta_desc' => $mdesc
                                ];
                            }
                        }
                        $data2['subCategories'] = $data3;
                        $subCategories[] = $data2;
                    }
                }

                $data['subCategories'] = $subCategories;
                $categories[] = $data;
            }
        }
        return response()->json(['status_code' => '200', 'categories' => $categories], 200);
    }

    public function search(Request $request){
        $categories = Category::where('name', 'like', '%' .$request->categoryName. '%')->paginate(5);

        return response()->json(['status_code' => '200', 'categories' => $categories], 200);
    }

    public function addCategory(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required',
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $parentID  = 0;

        if ($request->secondaryParentID)
            $parentID = $request->secondaryParentID;
        elseif ($request->parentID)
            $parentID = $request->parentID;
        else
            $parentID = 0;

        $sort = 1;
        $category = Category::where('parent', $parentID)->orderBy('sort', 'desc')->first();

        if ($category)
            $sort = $category->sort + 1;

        // Create slug from category name
        $categoryName = $request->categoryName;

        $string = trim($categoryName);
        $string = preg_replace('/[^\w-]/', '', $string);
        $string = str_replace(' ', '-', $string);
        $slug = strtolower($string);

        $slugCheck = Category::where('slug', $slug)->first();
        if ( $slugCheck != null ) {
            $duplicateNameCounter = Category::where('name', $categoryName)->count();
            $slug .= '-' . ($duplicateNameCounter + 1);
        }

        $category = Category::create([
            'name' => $request->categoryName,
            'slug' => $slug,
            'parent' => $parentID,
            'sort' => $sort,
        ]);
        $meta = Meta::create([
            'category' => $category->id,
            'title' => $request->MetaTitle, 
            'description' => $request->MetaDescription
        ]);

        return response()->json(['status_code' => '200','category' => $category], 200);
    }

    public function deleteCategory(Request $request) {
        $category = Category::where('id', $request->id)->first();
        $category->delete();
        return response()->json(['status_code' => '200', 'message' => 'Category Deleted Successfully'], 200);
    }

    public function updateCategory(Request $request) 
    {
        $category = Category::where('id', $request->id)->first();

        $parentID  = 0;
        
        if ($request->secondaryParentID)
            $parentID = $request->secondaryParentID;
        elseif ($request->parentID)
            $parentID = $request->parentID;
        else
            $parentID = 0;

        // Create slug from categoryname
        if($category->name != $request->categoryName){
            
            $categoryName = $request->categoryName;

            $string = trim($categoryName);
            $string = preg_replace('/[^\w-]/', '', $string);
            $string = str_replace(' ', '-', $string);
            $slug = strtolower($string);

            $slugCheck = Category::where('slug', $slug)->first();

            if ( $slugCheck != null ) {
                $duplicateNameCounter = Category::where('name', $categoryName)->count();
                $slug .= '-' . ($duplicateNameCounter + 1);
            }
        }else{
            $slug = $category->slug;
        }

        $category->parent = $parentID;
        $category->name = $request->categoryName;
        $category->slug = $slug;
        $category->save();

        $data=[
              'title'=>  $request->MetaTitle,
              'description'=>  $request->MetaDescription
            ]; 
         
        $meta_check=Meta::where('category',$request->id)->first();

        if(!empty($meta_check)){
            DB::table('metas')->where('category','=',$request->id)->update($data);
        }else{
           $meta = Meta::create([
                'category' => $request->id,
                'title' => $request->MetaTitle, 
                'description' => $request->MetaDescription
            ]); 
        }
        return response()->json(['status_code' => '200', 'message' => 'Category Updated Successfully', 'category' => $category], 200);
    }

    public function updateCategoryParent(Request $request) {
        $category = Category::where('id', $request->id)->first();

        $category->parent = $request->parent;
        $category->save();
    }

    public function sortCategory(Request $request) {
        $parentSort = 1;

        foreach($request->itemArray as $parent) {
            Category::where('id', $parent['id'])->update(['sort' => $parentSort, 'parent' => 0]);

            if (isset($parent['children'])) {
                $children1 = 1;

                foreach($parent['children'] as $item) {
                    Category::where('id', $item['id'])->update(['sort' => $children1, 'parent' => $parent['id']]);

                    if (isset($item['children'])) {
                        $children2 = 1;

                        foreach($item['children'] as $item2) {
                            Category::where('id', $item2['id'])->update(['sort' => $children2, 'parent' => $item['id']]);
                            $children2++;
                        }

                    }

                    $children1++;
                }
            }

            $parentSort++;
        }
    }
}
