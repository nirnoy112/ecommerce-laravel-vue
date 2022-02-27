<?php

namespace App\Model;

use App\Enumeration\OrderStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DB;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $user = $this;
        Mail::send('emails.buyer.password_reset', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->subject('Reset Password');
            $message->to($user->email, $user->first_name.' '.$user->last_name);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'user_name', 'password', 'role', 'active', 'buyer_meta_id','last_login', 'vendor_meta_id',
        'order_count', 'login_count', 'facebook_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function vendor() {
        return $this->hasOne('App\Model\MetaVendor', 'id', 'vendor_meta_id');
    }

    public function buyer() {
        return $this->hasOne('App\Model\MetaBuyer', 'id', 'buyer_meta_id')
            ->with('billingState', 'billingCountry');
    }

    public function permissions() {
        $permissions = [];

        $obj = DB::table('user_permission')->where('user_id', $this->id)->get();

        foreach($obj as $item)
            $permissions[] = $item->permission;

        return $permissions;
    }

    public function storeCredit() {
        $sc = 0;

        $storeCredit = StoreCredit::where('user_id', Auth::user()->id)->first();

        if ($storeCredit)
            $sc = $storeCredit->amount;

        return $sc;
    }

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }

    public function orders() {
        return $this->hasMany('App\Model\Order', 'user_id')->where('status', '!=', OrderStatus::$INIT);
    }

    public function buyerShippinAddress()
    {
        return $this->hasOne('App\Model\BuyerShippingAddress', 'user_id', 'id');
    }

    public function buyerShipping()
    {
        return $this->hasOne('App\Model\BuyerShippingAddress', 'user_id', 'id');
    }
}
