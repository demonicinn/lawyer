<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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


    protected $appends = [
        'name', 'profile_pic'
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfilePicAttribute()
    {
        if ($this->image) {
            return asset('storage/images/' . $this->image);
        }
        return asset('assets/images/sample-img.png');
    }



    public function details()
    {
        return $this->hasOne(UserDetails::class, 'users_id', 'id');
    }

    public function bankInfo()
    {
        return $this->hasOne(BankInfo::class, 'user_id', 'id');
    }

    public function lawyerSubscription()
    {
        return $this->hasMany(LawyerSubscription::class, 'users_id', 'id');
    }

    public function lawyerSubscriptionLast()
    {
        return $this->hasOne(LawyerSubscription::class, 'users_id', 'id')->orderBy('id', 'desc');
    }

    public function lawyerLitigations()
    {
        return $this->hasMany(LawyerLitigations::class, 'users_id', 'id');
    }

    public function lawyerContracts()
    {
        return $this->hasMany(LawyerContracts::class, 'users_id', 'id');
    }

    public function lawyerHours()
    {
        return $this->hasMany(LawyerHours::class, 'users_id', 'id');
    }


    

    public function lawyerInfo()
    {
        return $this->hasMany(Lawyer_info::class, 'user_id', 'id');
    }

    public function userCards()
    {
        return $this->hasMany(UserCard::class, 'user_id', 'id');
    }

    public function leave()
    {
        return $this->hasMany(Leave::class, 'user_id', 'id');
    }

    public function savedLawyer()
    {
        return $this->hasMany(SavedLawyer::class, 'user_id', 'id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'lawyer_id', 'id');
    }

    public function bookingUser()
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }

    public function lawyerCategory()
    {
        return $this->hasOne(Lawyer_info::class, 'user_id', 'id');
    }


    public function lawyerReviews()
    {
        return $this->hasMany(LawyerReviews::class, 'lawyer_id', 'id');
    }


    public function lawyerStateBar()
    {
        return $this->hasMany(LawyerStateBar::class, 'user_id', 'id');
    }










    public static function getDays()
    {
        return ['Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday'];
    }
    
    
    
    public static function getTime()
    {
        return [
            '00:00:00' => '00:00',
            '00:30:00' => '00:30',
            '01:00:00' => '01:00',
            '01:30:00' => '01:30',
            '02:00:00' => '02:00',
            '02:30:00' => '02:30',
            '03:00:00' => '03:00',
            '03:30:00' => '03:30',
            '04:00:00' => '04:00',
            '04:30:00' => '04:30',
            '05:00:00' => '05:00',
            '05:30:00' => '05:30',
            '06:00:00' => '06:00',
            '06:30:00' => '06:30',
            '07:00:00' => '07:00',
            '07:30:00' => '07:30',
            '08:00:00' => '08:00',
            '08:30:00' => '08:30',
            '09:00:00' => '09:00',
            '09:30:00' => '09:30',
            '10:00:00' => '10:00',
            '10:30:00' => '10:30',
            '11:00:00' => '11:00',
            '11:30:00' => '11:30',
            '12:00:00' => '12:00',
            '12:30:00' => '12:30',
            '13:00:00' => '13:00',
            '13:30:00' => '13:30',
            '14:00:00' => '14:00',
            '14:30:00' => '14:30',
            '15:00:00' => '15:00',
            '15:30:00' => '15:30',
            '16:00:00' => '16:00',
            '16:30:00' => '16:30',
            '17:00:00' => '17:00',
            '17:30:00' => '17:30',
            '18:00:00' => '18:00',
            '18:30:00' => '18:30',
            '19:00:00' => '19:00',
            '19:30:00' => '19:30',
            '20:00:00' => '20:00',
            '20:30:00' => '20:30',
            '21:00:00' => '21:00',
            '21:30:00' => '21:30',
            '22:00:00' => '22:00',
            '22:30:00' => '22:30',
            '23:00:00' => '23:00',
            '23:30:00' => '23:30',
        ];
    }
    
    
    
    
}
