<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PageEnumeration;
use App\Model\Page;
use App\Model\Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($id) {

        $meta = Meta::where('page', $id)->first();
        if (!$meta) {
            $meta = Meta::create([
                'page' => $id
            ]);
        }

        $page = Page::where('page_id', $id)->first();
        if (!$page) {
            $page = Page::create([
                'page_id' => $id,
            ]);
        }

        $title = 'Page/Meta - ';

        if ($id == PageEnumeration::$HOME)
            $title .= 'Home';
        if ($id == PageEnumeration::$ABOUT_US)
            $title .= 'About Us';
        else if ($id == PageEnumeration::$CONTACT_US)
            $title .= 'Contact Us';
        else if ($id == PageEnumeration::$PRIVACY_POLICY)
            $title .= 'Privacy Policy';
        else if ($id == PageEnumeration::$RETURN_POLICY)
            $title .= 'Return Policy';
        else if ($id == PageEnumeration::$SIZE_GUIDE)
            $title .= 'Size Guide';
        else if ($id == PageEnumeration::$TERMS_AND_CONDIOTIONS)
            $title .= 'Terms and Conditions';       
        else if ($id == PageEnumeration::$HOME_PAGE_CUSTOM_SECTION)
            $title .= 'Home Page Custome Section';

        return view('admin.dashboard.page.index', compact('page', 'meta'))->with('page_title', $title);
    }

    public function save(Request $request, $id) {
        Page::where('page_id', $id)->update([
            'content' => $request->page_editor,
            'url' => $request->url,
        ]);

        Meta::where('page', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('message', 'Updated!');
    }
}
