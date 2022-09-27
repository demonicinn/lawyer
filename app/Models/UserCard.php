<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;


    public function getExpireMonthAttribute($value){
        return ($value <= 9 ? '0'.$value : $value);
    }


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   
}
