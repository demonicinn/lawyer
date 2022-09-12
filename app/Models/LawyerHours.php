<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerHours extends Model
{
    use HasFactory;

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'user_id', 'users_id');
    }
}
