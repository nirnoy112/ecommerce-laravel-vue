<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
        $defaultCategories = [];
        $categoriesCollection = Category::orderBy('sort')->orderBy('name')->get(); 
        foreach($categoriesCollection as $cc) {
            if ($cc->parent == 0) {
                $data = [
                    'id' => $cc->id,
                    'name' => $cc->name,
                    'slug' => $cc->slug,
                    'image' => $cc->image
                ];

                $subCategories = [];
                foreach($categoriesCollection as $item) {
                    if ($item->parent == $cc->id) {
                        $data2 = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'slug' => $item->slug,
                            'image' => $cc->image
                        ];

                        $data3 = [];
                        foreach($categoriesCollection as $item2) {
                            if ($item2->parent == $item->id) {
                                $data3[] = [
                                    'id' => $item2->id,
                                    'name' => $item2->name,
                                    'slug' => $item2->slug,
                                    'image' => $cc->image
                                ];
                            }
                             
                        }

                        $data2['thirdcategory'] = $data3;
                        $subCategories[] = $data2;
                    }
                }

                $data['subCategories'] = $subCategories;
                $defaultCategories[] = $data;
            }
        } 
         
        return response()->json(['categories'=>$defaultCategories],200); 
    }
    
}
