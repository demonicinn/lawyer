<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    //protected $with = ['states'];
    
    public function states()
    {
        return $this->belongsTo(State::class, 'states_id', 'id');
    }

}
