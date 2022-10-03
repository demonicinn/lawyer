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

    public function lawyerSubscription()
    {
        return $this->hasMany(LawyerSubscription::class, 'users_id', 'id');
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


    public static function getDays()
    {
        return ['Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday'];
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
        return $this->hasOne(SavedLawyer::class, 'lawyer_id', 'id');
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


}
