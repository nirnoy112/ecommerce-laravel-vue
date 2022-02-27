<?php

namespace App\Http\Controllers\Api\Admin;

use App\Model\Color;
use App\Model\MasterColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Uuid;
use Auth;
use File;
use Image;
use Validator;

class ColorController extends Controller
{
    public function index() {
        $colors = Color::orderBy('name')->paginate(5);
        $masterColors = MasterColor::orderBy('name')->get();

        return response()->json(['status_code' => '200', 'page_title' => 'Color','colors' => $colors, 'masterColors' => $masterColors], 200);
    }

    public function search(Request $request){
        $colors = Color::where('name', 'like', '%' .$request->color_name. '%')->paginate(5);

        return response()->json(['status_code' => '200', 'colors' => $colors], 200);
    }

    public function addPost(Request $request) {

        $validator = Validator::make($request->all(), [
            'color_name' => 'required',
            'master_color_id' => 'required',
            'photo' => 'nullable|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $imagePath = null;
        $thumbsPath = null;

        if ($request->photo) {
            $filename = Uuid::generate()->string;
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();

            $destinationPath = '/images/colors';
            $thumbsPath = '/images/colors/thumbs/'.$filename.'.'.$ext;

            // Thumbs Image
            $thumb = Image::make($file->getRealPath())->resize(40, 40);
            $thumb->save(public_path($thumbsPath), 60);

            $file->move(public_path($destinationPath), $filename.".".$ext);

            $imagePath = $destinationPath."/".$filename.".".$ext;
        }


        Color::create([
            'name' => $request->color_name,
            'master_color_id' => $request->master_color_id,
            'status' => $request->status,
            'image_path' => $imagePath,
            'thumbs_image_path' => $thumbsPath,
        ]);

        return response()->json(['status_code' => '200', 'message' => 'Color Added!'], 200);
    }

    public function editPost(Request $request) {

        $validator = Validator::make($request->all(), [
            'color_name' => 'required',
            'master_color_id' => 'required',
            'photo' => 'nullable|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $color = Color::where('id', $request->colorId)->first();

        $imagePath = null;
        $thumbsPath = null;

        if ($request->photo) {
            if ($color->image_path != null)
                File::delete(public_path($color->image_path));
            if ($color->thumbs_image_path != null)
                File::delete(public_path($color->thumbs_image_path));

            $filename = Uuid::generate()->string;
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();

            $destinationPath = '/images/colors';
            $thumbsPath = '/images/colors/thumbs/'.$filename.'.'.$ext;

            // Thumbs Image
            $thumb = Image::make($file->getRealPath())->resize(40, 40);
            $thumb->save(public_path($thumbsPath), 60);

            $file->move(public_path($destinationPath), $filename.".".$ext);

            $imagePath = $destinationPath."/".$filename.".".$ext;

            $color->image_path = $imagePath;
            $color->thumbs_image_path = $thumbsPath;
        }

        $color->name = $request->color_name;
        $color->status = $request->status;
        $color->master_color_id = $request->master_color_id;
        $color->save();
        $color->touch();

        return response()->json(['status_code' => '200', 'message' => 'Color Updated!', 'color' => $color], 200);
    }

    public function delete(Request $request) {
        $color = Color::where('id', $request->id)->first();

        if ($color->image_path != null)
            File::delete(public_path($color->image_path));
            File::delete(public_path($color->thumbs_image_path));

        $color->delete();

        return response()->json(['status_code' => '200', 'message' => 'Color Deleted Successfully'], 200);
    }
}
