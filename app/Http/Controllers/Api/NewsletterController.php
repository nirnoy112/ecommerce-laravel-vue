<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Newsletter;

class NewsletterController extends Controller
{
    public function addNewsletter(Request $request) {
        $request->validate([
            'email' => 'required|string|email', 
        ]);
        
        $newsletter = Newsletter::where('email', $request->email)->first(); 

        if ($newsletter) {
            return response()->json(['message' => 'Thank you for your concern. We already have your email.','status'=>'success'], 200);
        } else {
            $newsletter = Newsletter::create(['email' => $request->email]); 
            return response()->json(['message' => 'Thank you for your concern. We recieved your request.','status'=>'success'], 200);
        }
    }
    public function newsletterUpdate(Request $request) {
        // $request->validate([
        //     'status' => 'required|in:true,false', 
        // ]);
        
        $newsletter = Newsletter::where('email', $request->user()->email)->first(); 

        if ($newsletter) {
            $newsletter->delete();
            return response()->json(['message' => 'Thank you for your concern. Your email is ditached from subscription.','status'=>'success'], 200);
        } else {
            $newsletter = Newsletter::create(['email' => $request->user()->email]); 
            return response()->json(['message' => 'Thank you for your concern. We recieved your request.','status'=>'success'], 200);
        }
    }
}
