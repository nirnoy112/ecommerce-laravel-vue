<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\Model\User;
use App\Model\MetaBuyer;
use App\Model\BuyerShippingAddress;
use App\Enumeration\Role;
use Hash;
use Carbon\Carbon;
use App\Model\LoginHistory;

class AuthController extends Controller
{
    public function adminLogin() {
        return view('admin-v2.auth.login');
    }

    public function loginPost(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
        	return response()->json(['status_code' => '401','error' => $validator->errors()], 401);
        }

        $user = User::where('user_name', $request->username)
        ->whereIn('role', [Role::$ADMIN, Role::$EMPLOYEE])
        ->first();

        if (!$user)
            return response()->json(['status_code' => '404','error' => 'Username not found.'], 404);

        if ($user->active == 0)
            return response()->json(['status_code' => '404','error' => 'Username not active.'], 404);

        if (Hash::check($request->password, $user->password)) {
            if ($request->remember_me)
                Auth::login($user, true);
            else
                Auth::login($user);

            $user->last_login = Carbon::now()->toDateTimeString();
            $user->save();

            LoginHistory::create([
                'user_id' => $user->id,
                'ip' => $request->ip()
            ]);

            return response()->json(['status_code' => '200','user' => $user], 200);
        }else{
        	return response()->json(['status_code' => '401','error' => 'Invalid Password.'], 401);
        }
    }

    public function AdminLogout(){
        Auth::logout();
        return response()->json(['status_code' => '200'], 200);
    }
}
