<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Package;
use App\Models\Wishlist;
use App\Notifications\CustomVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'email_verified_at', 'seller_verified_at', 'mobile', 'dob', 'gender', 'password', 'avatar','business','address','deleted_at','category_id','wallet_balance','gst_name','gst_no','otp', 'otp_expiry','google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function usermapping()
    {
        return $this->belongsTo('App\Models\UserMapping');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\UserAddress');
    }

    public function bank()
    {
        return $this->hasOne('App\Models\UserBank');
    }

    public function upi()
    {
        return $this->hasOne('App\Models\UserUpi');
    }

    public function legals()
    {
        return $this->hasMany('App\Models\UserLegal');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function wishlist(){
        return $this->hasMany('App\Models\Wishlist');
    }

    public function usermappings(){
        return $this->hasMany('App\Models\UserMapping');
    }



    static function updateWallet($userId){
        return true;
    }

    public function getWalletBalanceAttribute() {
        $res = 0;
        // $commissions = Commission::whereSellerId($this->id)->whereDate('payment_at', '<', now())->get();
        // foreach ($commissions as $key => $commission) {
        //     $res = $res + (float)$commission->seller_earning;
        // }

        // $payouts = Payout::whereUserId($this->id)->get();
        // foreach ($payouts as $key => $payout) {
        //     $res = $res - (float)$payout->requested_amt;
        // }

        // $this->wallet_balance = $res;
        // $this->save();

        return $res;
    }

    public function getTotalEarnedAmtAttribute()
    {
        $res = 0;
        // $commissions = Commission::whereSellerId($this->id)->get();
        // foreach ($commissions as $key => $commission) {
        //     $res = $res + (float)$commission->seller_earning;
        // }
        return $res;
    }

    public function getRequestedAmtAttribute()
    {
        $res = 0;
        $payouts = Payout::whereUserId($this->id)->where('status','!=','Successful')->get();
        foreach ($payouts as $key => $payout) {
            $res = $res + (float)$payout->requested_amt;
        }
        return $res;
    }

    public function getWithdrawAmtAttribute()
    {
        $res = 0;
        $payouts = Payout::whereUserId($this->id)->whereStatus('Successful')->get();
        foreach ($payouts as $key => $payout) {
            $res = $res + (float)$payout->requested_amt;
        }
        return $res;
    }

    public function getTotalSaleAmtAttribute() {
        $res = 0;
        $orderItems = OrderItem::whereSellerId($this->id)
                                ->whereHas('order', function($q) {
                                    $q->whereOrderStatus('Delivered');
                                })->get();

        foreach ($orderItems as $key => $item) {
            $res = $res + (float)(($item->price + $item->tax) * $item->qty);
        }
        return $res;
    }

    // public function wishlists()
    // {
    //     return $this->belongsToMany(Package::class, 'wishlists', 'user_id', 'package_id')->using(Wishlist::class);
    // }

    public function sendEmailVerificationNotification() {
        $this->notify(new CustomVerifyEmail());
    }

    public function hasPermissionTo($slug)
    {
        foreach ($this->role->permissions as $permission) {
            if ($permission->slug == $slug) {
                return true;
            }
        }
        return false;
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
