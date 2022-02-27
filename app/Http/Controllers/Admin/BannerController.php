<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use Uuid;
use Carbon\Carbon;
use ImageOptimizer;
use App\Model\Setting;
use App\Model\VendorImage;
use Illuminate\Http\Request;
use App\Enumeration\PageEnumeration;
use App\Enumeration\VendorImageType;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    //Logo Start
    public function logo(Request $request) {

        $logoBig = DB::table('settings')->where('name', 'logo-big')->where('status',1)->first();
        $logoSmalls = DB::table('settings')->where('name', 'logo-small')->where('status',1)->first();

        return view('admin.dashboard.marketing_tools.logo.index', compact('logoBig', 'logoSmalls'))->with('page_title', 'Logo');
    }

    public function logoPost(Request $request) {
        $request->validate([
            'bigLogo' => 'nullable|mimes:jpeg,jpg,png,svg',
            'smallLogo' => 'nullable|mimes:jpeg,jpg,png,svg',

        ]);
        if ($request->bigLogo) {
            $file = $request->file('bigLogo');
            $this->uploadLogo($file, 'logo-big');
        }

        if ($request->smallLogo) {
            $file = $request->file('smallLogo');
            $this->uploadLogo($file, 'logo-small');
        }

        return redirect()->route('admin_logo')->with('message', 'Successfully Added!.');
    }

    public function uploadLogo($file, $type) {
        $filename = Uuid::generate()->string;
        $ext = $file->getClientOriginalExtension();
        $destinationPath = 'images/logo';
        $file->move(public_path($destinationPath), $filename.".".$ext);
        $imagePath = $destinationPath."/".$filename.".".$ext;

        $logo = DB::table('settings')->where('name', $type)->first();

        if(!empty($logo)){
            DB::table('settings')->where('name', $type)->update(['value' => $imagePath,'status' => 1, 'created_at'=>Carbon::now()]);
        }else{
            DB::table('settings')->insert([
                [
                    'name' => $type,
                    'value' => $imagePath,
                    'status' => 1,
                    'created_at' => Carbon::now()
                ]
            ]);
        }
    }

    public function LogoRemove(Request $request) { 

        Setting::where('id', $request->id)->update([
            'status' => 0, 
        ]);
    }
    //Logo End

    //Main Banner Start
    public function mainBanner() {
        $bannerImages = VendorImage::where('type', VendorImageType::$MAIN_BANNER)
            ->orderBy('sort')
            ->get();

        return view('admin.dashboard.marketing_tools.main_banner.index', compact('bannerImages'))->with('page_title', 'Main Banner');
    }

    public function mainBannerAdd(Request $request) {
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,mp4'
        ]);

        $bannerWidth = 1920;
        switch ($request->type) {
            case VendorImageType::$MAIN_BANNER:
                $bannerWidth = 1920;
                $sort = VendorImage::where('type', VendorImageType::$MAIN_BANNER)->max('sort');
                break;
            default:
                $bannerWidth = 1920;
                $sort = 999;
                break;
        }

        $filename = Uuid::generate()->string;
        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $compressedSavePath = null;

        if($ext == 'mp4'){

            $destinationPath = '/images/banner';
            $file->move(public_path($destinationPath), $filename.".".$ext);
            $savePath = $destinationPath."/".$filename.".".$ext;
            $compressedSavePath = $savePath;

        }else{

            $image = $request->file('photo');
            $tempImagePath = temporaryImageUpload($image);
            $allPaths = imageMove($tempImagePath, $folderName = 'banner', $imageStoreTypes = ['image_path', 'custom_compressed'], $bannerWidth);
            $savePath = $allPaths['image_path'];
            $compressedSavePath = $allPaths['custom_compressed'];
        }

        if ($sort == null || $sort == '')
            $sort = 0;

        $sort++;

        VendorImage::create([
            'type' => VendorImageType::$MAIN_BANNER,
            'image_path' => $compressedSavePath,
            'url' => $request->link,
            'title' => $request->title,
            'details' => $request->description,
            'status' => 1,
            'sort' => $sort
        ]);

        return redirect()->back()->with('message', 'Successfully Added!.');
    }

    public function mainBannerSort(Request $request) {
        $sort = 1;

        foreach ($request->ids as $id) {
            VendorImage::where('id', $id)->update(['sort' => $sort]);
            $sort++;
        }
    }

    public function mainBannerUpdate(Request $request) {
        VendorImage::where('id', $request->id)->update([
            'url' => $request->url,
            'title' => $request->title,
            'details' => $request->description
        ]);
    }

    public function mainBannerDelete(Request $request) {
        $image = VendorImage::where('id', $request->id)->first();

        if ($image->image_path != null)
            File::delete(public_path($image->image_path));

        $image->delete();
    }
    //Main Banner End

    //Section Two Banner Start
    public function sectionTwoBanner() {
        $sectionTwoBanners = VendorImage::where('type', VendorImageType::$SECTION_TWO_BANNER)
            ->orderBy('sort')
            ->get();

        return view('admin.dashboard.marketing_tools.section_two_banner.index', compact('sectionTwoBanners'))->with('page_title', 'Section Two Banner');
    }

    public function sectionTwoBannerAdd(Request $request) {
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,mp4'
        ]);

        $bannerWidth = 400;
        switch ($request->type) {
            case VendorImageType::$SECTION_TWO_BANNER:
                $bannerWidth = 1920;
                $sort = VendorImage::where('type', VendorImageType::$SECTION_TWO_BANNER)->max('sort');
                break;
            default:
                $bannerWidth = 400;
                $sort = 999;
                break;
        }

        $filename = Uuid::generate()->string;
        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $compressedSavePath = null;

        if($ext == 'mp4'){
            $destinationPath = '/images/banner';
            $file->move(public_path($destinationPath), $filename.".".$ext);
            $savePath = $destinationPath."/".$filename.".".$ext;
            $compressedSavePath = $savePath;

        }else{

            $image = $request->file('photo');
            $tempImagePath = temporaryImageUpload($image);
            $allPaths = imageMove($tempImagePath, $folderName = 'banner', $imageStoreTypes = ['image_path', 'custom_compressed'], $bannerWidth);
            $savePath = $allPaths['image_path'];
            $compressedSavePath = $allPaths['custom_compressed'];

        }

        if ($sort == null || $sort == '')
            $sort = 0;

        $sort++;

        VendorImage::create([
            'type' => VendorImageType::$SECTION_TWO_BANNER,
            'image_path' => $compressedSavePath,
            'url' => $request->link,
            'title' => $request->title,
            'details' => $request->description,
            'status' => 1,
            'sort' => $sort
        ]);
        return redirect()->back()->with('message', 'Successfully Added!.');
    }

    public function sectionTwoBannerSort(Request $request) {
        $sort = 1;

        foreach ($request->ids as $id) {
            VendorImage::where('id', $id)->update(['sort' => $sort]);
            $sort++;
        }
    }

    public function sectionTwoBannerUpdate(Request $request) {
        VendorImage::where('id', $request->id)->update([
            'url' => $request->url,
            'title' => $request->title,
            'details' => $request->description
        ]);
    }

    public function sectionTwoBannerDelete(Request $request) {
        $image = VendorImage::where('id', $request->id)->first();

        if ($image->image_path != null)
            File::delete(public_path($image->image_path));

        $image->delete();
    }
    //Section Two Banner End
}
