<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerStateBar extends Model
{
    use HasFactory;

    //protected $with = ['statebar'];
    
    public function statebar()
    {
        return $this->belongsTo(StateBar::class, 'state_bar_id', 'id');
    }
}
