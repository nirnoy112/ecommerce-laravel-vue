<?php

namespace App\Http\Controllers\Buyer;

use App\Enumeration\Role;
use App\Model\BuyerMessage;
use App\Model\BuyerShippingAddress;
use App\Model\Country;
use App\Model\LoginHistory;
use App\Model\MetaBuyer;
use App\Model\State;
use App\Model\CartItem;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Uuid;
 
use Carbon\Carbon;
use Mail;
use App\Events\UserRegistered;
use Session;
use  Spatie\Newsletter\NewsletterFacade as Newsletter;

class AuthController extends Controller
{
    public function register() {
        $countries = Country::orderBy('name')->get();
        $usStates = State::where('country_id', 1)->orderBy('name')->get()->toArray();
        $caStates = State::where('country_id', 2)->orderBy('name')->get()->toArray();

        return view('buyer.auth.register', compact('countries', 'usStates', 'caStates'))->with('page_title', 'Buyer Register');
    }

    public function registerPost(Request $request) {
        $messages = [
            'required' => 'This field is required.',
        ];

        $rules = [
            'companyName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:255|unique:users',
            'sellerPermitNumber' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zipCode' => 'required|string|max:255',
            'country' => 'required',
            'phone' => 'required|max:255',
            'fax' => 'nullable|max:255',
            'factoryAddress' => 'required|string|max:255',
            'factoryUnit' => 'nullable|string|max:255',
            'factoryCity' => 'required|string|max:255',
            'factoryZipCode' => 'required|string|max:255',
            'factoryCountry' => 'required',
            'factoryPhone' => 'required|max:255',
            'factoryFax' => 'nullable|max:255',
            'ein' => 'required_without_all:sales1,sales2|mimes:jpeg,jpg,png,pdf',
        ];

        if ($request->location == "INT")
            $rules['state'] = 'required|string|max:255';
        else
            $rules['stateSelect'] = 'required';

        if ($request->factoryLocation == "INT")
            $rules['factoryState'] = 'required|string|max:255';
        else
            $rules['factoryStateSelect'] = 'required';

        if ($request->sellOnline && $request->sellOnline == '1')
            $rules['website'] = 'required|string|max:255';

        $request->validate($rules, $messages);

        $state_id = null;
        $state = null;
        $factory_state_id = null;
        $factory_state = null;
        $hearFromOtherText = null;

        if ($request->location == "INT")
            $state = $request->state;
        else
            $state_id = $request->stateSelect;

        if ($request->factoryLocation == "INT")
            $factory_state = $request->factoryState;
        else
            $factory_state_id = $request->factoryStateSelect;

        // File Upload - ein
        $einPath = null;
        $destinationPath = '/files/buyer';
        if ($request->ein && $request->ein != null) {
            $filename = Uuid::generate()->string;
            $file = $request->file('ein');
            $ext = $file->getClientOriginalExtension();
            $file->move(public_path($destinationPath), $filename . "." . $ext);
            $einPath = $destinationPath . "/" . $filename . "." . $ext;
        }

        $meta = MetaBuyer::create([
            'verified' => 0,
            'active' => 1,
            'user_id' => 0,
            'company_name' => $request->companyName,
            'primary_customer_market' => $request->primaryCustomerMarket,
            'seller_permit_number' => $request->sellerPermitNumber,
            'sell_online' => $request->sellOnline,
            'website' => $request->website,
            'attention' => $request->attention,
            'billing_location' => $request->factoryLocation,
            'billing_address' => $request->factoryAddress,
            'billing_unit' => $request->factoryUnit,
            'billing_city' => $request->factoryCity,
            'billing_state_id' => $factory_state_id,
            'billing_state' => $factory_state,
            'billing_zip' => $request->factoryZipCode,
            'billing_country_id' => $request->factoryCountry,
            'billing_phone' => $request->factoryPhone,
            'billing_fax' => $request->factoryFax,
            'billing_commercial' => ($request->factoryCommercial == null) ? 0 : 1,
            'receive_offers' => $request->receiveSpecialOffers,
            'mailing_list' => $request->receiveSpecialOffers,
            'ein_path' => $einPath,
        ]);

        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::$BUYER,
            'buyer_meta_id' => $meta->id,
        ]);

        BuyerShippingAddress::create([
            'user_id' => $user->id,
            'default' => 1,
            'store_no' => $request->store_no,
            'location' => $request->location,
            'address' => $request->address,
            'unit' => $request->unit,
            'city' => $request->city,
            'state_id' => $state_id,
            'state_text' => $state,
            'zip' => $request->zipCode,
            'country_id' => $request->country,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'commercial' => ($request->showroomCommercial == null) ? 0 : 1,
        ]);

        $meta->user_id = $user->id;
        $meta->save();

        // Merge address and phone into user object
        $user->phone = $request->phone;
        $user->local_address = $request->address;

        //Trigger event for mailchimp
        // event(new UserRegistered($user));

        // Trigger event for mailchimp 
        // if(! Newsletter::isSubscribed($user->email)){
        //     Newsletter::subscribePending($user->email);  
        //  }

        //Send Mail to User
        // Mail::send('emails.buyer.registration_complete', [], function ($message) use ($request) {
        //     $message->subject('Registration Complete');
        //     $message->to($request->email, $request->firstName.' '.$request->lastName);
        // });

        //Send Mail to User
        // $admin = User::where('role', Role::$ADMIN)->first();

        // Mail::send('emails.admin.new_buyer', [], function ($message) use ($admin) {
        //     $message->subject('New Buyer');
        //     $message->to($admin->email, $admin->firstName.' '.$admin->lastName);
        // });

        return redirect()->route('buyer_register_complete');
    }

    public function registerComplete() {
        return view('buyer.auth.complete');
    }

    public function login() {
        return view('buyer.auth.login')->with('page_title', 'Login / Register Account');
    }

    public function loginPost(Request $request) { 
        $this-> validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]); 
        $user = User::where('email', $request->email)
            ->where('role', Role::$BUYER)
            ->with('buyer')->first();
             
        if (!$user){ 
            return response()->json(['message'=>'Email not found.'],200);  
        }
 
        if ($user->buyer->active == 0) {  
            return response()->json(['message'=>'Buyer not Active.'],200); 
        }
 
        if (Hash::check($request->password, $user->password)) { 
            if ($request->remember_me)
                Auth::login($user, true);
            else
                Auth::login($user);
            $user->last_login = Carbon::now()->toDateTimeString();
            $user->save(); 
            LoginHistory::create([
                'user_id' => $user->id,
                'ip' => $request->ip(),
            ]);
            $this->mergeGuestToAuth($request->ip()); 
             
            return response()->json(['message'=>'Login Successfull.'],200); 
        } 
        else{
            return response()->json(['message'=>'Invalid Password.'],200); 
        }
    }

    public function mergeGuestToAuth($ip){ 
        CartItem::where('user_id', $ip)->update(['user_id' => Auth::user()->id]); 
        return true;
    }

    public function logout()
    {
        Session::forget('sessionCartData');
        Auth::logout();
        return redirect()->route('home');
    }

    public function resetPassword() {
        return view('buyer.auth.reset_password');
    }

    public function resetPasswordPost(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);
        $user = User::where('role', Role::$BUYER)->where('email', $request->email)->first();

        if (!$user)
            return redirect()->back()->with('message', 'Email Not Found.')->withInput();

        $token = Uuid::generate()->string;

        $user->reset_token = $token;
        $user->save();

        Mail::send('emails.buyer.password_reset', ['token' => $token], function ($message) use ($user) {
            $message->subject('Reset Password');
            $message->to($user->email, $user->first_name.' '.$user->last_name);
        });

        return redirect()->back()->with('message', 'Email has sent with reset password link.');
    }


    public function newPassword(Request $request)
    {
        if ($request->token) {
            $user = User::where('role', Role::$BUYER)->where('reset_token', $request->token)->first();
            if (!$user)
                abort(404);
            return view('buyer.auth.new_password');
        } else {
            abort(404);
        }
    }

    public function newPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('role', Role::$BUYER)->where('reset_token', $request->token)->first();

        if (!$user)
            abort(404);

        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->save();

        return redirect()->route('buyer_login',compact('user'));
    }

    public function newBuyerPassword(Request $request)
    {
        if(Auth::user()){
            $data['unread_messages'] = BuyerMessage::where('user_id', Auth::user()->id)
                ->where('reading_status', 0)
                ->count();
        }
        $data['buyerAvatar'] = MetaBuyer::where('user_id', auth()->user()->id)->first();
        return view('buyer.profile.new_password',$data);
    }

    public function newBuyerPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('role', Role::$BUYER)->where('id', auth()->user()->id)->first();

        if ( ! $user ){
            abort(404);
        }
        $user->password = Hash::make($request->password);
        $user->reset_token = $request->token;
        $user->save();

        return redirect()->back()->with('flash_message_success', 'Password Updated Successfully.');
    }
}
