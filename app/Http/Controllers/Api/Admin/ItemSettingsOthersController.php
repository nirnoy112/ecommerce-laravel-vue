<?php

namespace App\Http\Controllers\Api\Admin;

use Auth;
use App\Model\Brand;
use Validator;
use App\Model\MadeInCountry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemSettingsOthersController extends Controller
{
    public function index() {

        $madeInCountries = MadeInCountry::orderBy('name')->paginate(5);

        $brands = Brand::OrderBy('name')->paginate(5);

        return response()->json(['status_code' => '200', 'page_title' => 'Brand, Made In Country','madeInCountries' => $madeInCountries, 'brands' => $brands], 200);
    }

    public function madeInCountrySearch(Request $request){

        if($request->name){
            $country = MadeInCountry::where('name', 'like', '%' .$request->name. '%')->paginate(5);
        }else{
            $country = MadeInCountry::paginate(5);
        }

        return response()->json(['status_code' => '200', 'country' => $country], 200);
    }

    public function madeInCountryAdd(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:name'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $country = MadeInCountry::create([
            'name' => $request->name,
            'status' => $request->status,
            'default' => $request->defaultVal,
        ]);

        return response()->json(['status_code' => '200', 'country' => $country, 'message' => 'Country Added Successfully!'], 200);
    }

    public function madeInCountryUpdate(Request $request) {

        $country = MadeInCountry::where('id', $request->id)->first();

        if ($request->defaultVal == '1')
            MadeInCountry::where([])->update([ 'default' => 0 ]);

        $country->name = $request->name;
        $country->status = $request->status;
        $country->default = $request->defaultVal;
        $country->save();

        return response()->json(['status_code' => '200', 'country' => $country, 'message' => 'Country Updated Successfully!'], 200);
    }

    public function madeInCountryDelete(Request $request) {

        $country = MadeInCountry::where('id', $request->id)->first();
        $country->delete();

        return response()->json(['status_code' => '200', 'message' => 'Country Deleted Successfully'], 200);
    }

    public function madeInCountryChangeStatus(Request $request) {

        $country = MadeInCountry::where('id', $request->id)->first();
        $country->status = $request->status;
        $country->save();

        return response()->json(['status_code' => '200', 'message' => 'Status Changes Successfully'], 200);
    }

    public function madeInCountryChangeDefault(Request $request) {

        MadeInCountry::where([])->update([ 'default' => 0 ]);
        $country = MadeInCountry::where('id', $request->id)->first();
        $country->default = 1;
        $country->save();

        return response()->json(['status_code' => '200', 'message' => 'Default Status Changes Successfully'], 200);
    }

    public function brandSearch(Request $request){

        if($request->name){
            $brand = Brand::where('name', 'like', '%' .$request->name. '%')->paginate(5);
        }else{
            $brand = Brand::paginate(5);
        }

        return response()->json(['status_code' => '200', 'brand' => $brand], 200);
    }

    public function brandAdd(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name'
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $brand = Brand::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['status_code' => '200', 'brand' => $brand, 'message' => 'brand Added Successfully!'], 200);
    }

    public function brandUpdate(Request $request) {

        $brand = Brand::where('id', $request->id)->first();

        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json(['status_code' => '200', 'brand' => $brand, 'message' => 'Brand Updated Successfully!'], 200);
    }

    public function brandDelete(Request $request) {

        $brand = Brand::where('id', $request->id)->first();
        $brand->delete();

        return response()->json(['status_code' => '200', 'message' => 'Brand Deleted Successfully'], 200);
    }

    public function brandChangeStatus(Request $request) {

        $country = Brand::where('id', $request->id)->first();
        $country->status = $request->status;
        $country->save();

        return response()->json(['status_code' => '200', 'message' => 'Status Changes Successfully'], 200);
    }

    public function brandChangeDefault(Request $request) {

        Brand::where([])->update([ 'default' => 0 ]);
        $country = Brand::where('id', $request->id)->first();
        $country->default = 1;
        $country->save();

        return response()->json(['status_code' => '200', 'message' => 'Default Status Changes Successfully'], 200);
    }
}
