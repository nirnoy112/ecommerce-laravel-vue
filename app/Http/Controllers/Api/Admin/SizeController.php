<?php

namespace App\Http\Controllers\Api\Admin;

use DB;
use Auth;
use Validator;
use App\Model\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
	public function index() {

      $sizes = Size::paginate(5);  

      return response()->json(['status_code' => '200', 'page_title' => 'size','sizes' => $sizes], 200);
    }

    public function search(Request $request){
        $colors = Size::where('name', 'like', '%' .$request->size_name. '%')->paginate(5);

        return response()->json(['status_code' => '200', 'colors' => $colors], 200);
    }

    public function addPost(Request $request) { 
        
        $validator = Validator::make($request->all(), [
            'size_name' => 'required',
            'item_size' => 'required'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $size = Size::create([
            'name' 	=> $request->size_name,
            'item_size' => $request->item_size,
            'desc' 	=> $request->desc,
            'status' => $request->status
        ]);

        return response()->json(['status_code' => '200', 'message' => 'Size Added!'], 200);
    } 

    public function editPost(Request $request) {

        $validator = Validator::make($request->all(), [
            'size_name' => 'required',
            'item_size' => 'required'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        } 

        $size = Size::where('id', $request->sizeId)->first(); 
        $size->name = $request->size_name;
        $size->item_size = $request->item_size;
        $size->desc = $request->desc;
        $size->status = $request->status; 
        $size->save(); 

        return response()->json(['status_code' => '200', 'message' => 'Size Updated!', 'size' => $size], 200);
    }

    public function delete(Request $request) {

        $size = Size::where('id', $request->sizeId)->first();
        $size->delete();

        return response()->json(['status_code' => '200', 'message' => 'Size Deleted Successfully'], 200);
    } 
}
