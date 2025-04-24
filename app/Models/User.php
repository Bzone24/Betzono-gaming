<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, UserNotify;

    public const USER_TYPE_USER = "USER";
    public const USER_TYPE_AGENT = "AGENT";

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','ver_code','balance','kyc_data','fast_create_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    public static function getUserTypeOptions(): array
    {
        return [
            self::USER_TYPE_USER,
            self::USER_TYPE_AGENT,
        ];
    }

    public static function getUserTypeOptionList(): array
    {
        return [
            self::USER_TYPE_USER => __('User'),
            self::USER_TYPE_AGENT => __('Agent'),
        ];
    }

    public static function getUserTypeName($type): string
    {
        $types = self::getUserTypeOptionList();
        return $types[$type] ?? __('--');
    }


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status','!=',Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status','!=',Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function wins()
    {
        return $this->hasMany(Winner::class);
    }

    public function lotteryTickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'ref_by');
    }
    public function referral()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function allReferrals()
    {
        return $this->referral()->with('referrer');
    }

    public function commissions()
    {
        return $this->hasMany(CommissionLog::class, 'to_id');
    }


    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn () => $this->dial_code . $this->mobile,
        );
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev',Status::VERIFIED)->where('sv',Status::VERIFIED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance','>', 0);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
    
     public function sharingUserToken()
    {
        return $this->hasMany(SharingUserToken::class,'user_id');
    }
    
    
    public function getSharingToken(){
        
        $sessionId = auth()->getSession()->getId();
       return $this->sharingUserToken()
        ->where('session_id', $sessionId)
        ->value('token');
        
    }

}
