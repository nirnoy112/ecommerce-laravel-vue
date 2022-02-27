<?php

namespace App\Http\Controllers\Api\Admin;

use App\Model\MasterColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Uuid;
use File;
use Validator;

class MasterColorController extends Controller
{
    public function index() {
        $colors = MasterColor::orderBy('name')->paginate(5);

        return response()->json(['status_code' => '200', 'page_title' => 'Master Color','colors' => $colors], 200);
    }

    public function search(Request $request){
        $colors = MasterColor::where('name', 'like', '%' .$request->color_name. '%')->paginate(5);

        return response()->json(['status_code' => '200', 'colors' => $colors], 200);
    }

    public function addPost(Request $request) {

        $validator = Validator::make($request->all(), [
            'color_name' => 'required|unique:master_colors,name',
            'photo' => 'required|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $imagePath = null;

        if ($request->photo) {
            $filename = Uuid::generate()->string;
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();


            $destinationPath = '/images/master_color';

            $file->move(public_path($destinationPath), $filename.".".$ext);

            $imagePath = $destinationPath."/".$filename.".".$ext;
        }

        MasterColor::create([
            'name' => $request->color_name,
            'image_path' => $imagePath,
        ]);
        
        return response()->json(['status_code' => '200', 'message' => 'Master Color Added!'], 200);
    }

    public function delete(Request $request) {
        $color = MasterColor::where('id', $request->id)->first();

        if ($color->image_path != null)
            File::delete(public_path($color->image_path));

        $color->delete();

        return response()->json(['status_code' => '200', 'message' => 'Master Color Deleted Successfully'], 200);
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'color_name' => 'required|unique:master_colors,name,'.$request->colorId,
            'photo' => 'nullable|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $color = MasterColor::where('id', $request->colorId)->first();

        $imagePath = null;

        if ($request->photo) {
            if ($color->image_path != null)
                File::delete(public_path($color->image_path));

            $filename = Uuid::generate()->string;
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();

            $destinationPath = '/images/master_color';

            $file->move(public_path($destinationPath), $filename.".".$ext);

            $imagePath = $destinationPath."/".$filename.".".$ext;

            $color->image_path = $imagePath;
        }

        $color->name = $request->color_name;

        $color->save();

        return response()->json(['status_code' => '200', 'message' => 'Master Color Updated Successfully', 'color' => $color], 200);
    }
}
