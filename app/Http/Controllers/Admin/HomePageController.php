<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Meta;
use App\Model\HomePage;

class HomePageController extends Controller
{
    public function index() {
    	$meta = Meta::where('page', 1)->first();
        if (!$meta) {
            $meta = Meta::create([
                'page' => 1
            ]);
        }
        $sectionOne = HomePage::where('section_id', 1)->first();
        if (!$sectionOne) {
            $sectionOne = HomePage::create([
                'section_id' => 1,
            ]);
        }
        $sectionThree = HomePage::where('section_id', 3)->first();
        if (!$sectionThree) {
            $sectionThree = HomePage::create([
                'section_id' => 3,
            ]);
        }
        $sectionFour = HomePage::where('section_id', 4)->first();
        if (!$sectionFour) {
            $sectionFour = HomePage::create([
                'section_id' => 4,
            ]);
        }
        $sectionFive = HomePage::where('section_id', 5)->first();
        if (!$sectionFive) {
            $sectionFive = HomePage::create([
                'section_id' => 5,
            ]);
        }
        return view('admin.dashboard.home_page.index', compact('meta','sectionOne','sectionThree','sectionFour','sectionFive'))->with('page_title', 'Page/Meta - Home');
    }

    public function save(Request $request, $id) {
        HomePage::where('section_id', $id)->update([
            'content' => $request->page_editor
        ]);

        Meta::where('page', 1)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('message', 'Updated!');
    }
}
