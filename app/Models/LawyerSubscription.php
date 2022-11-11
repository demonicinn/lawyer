<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerSubscription extends Model
{
    use HasFactory;

    //protected $with = ['subscription', 'user'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscriptions_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
