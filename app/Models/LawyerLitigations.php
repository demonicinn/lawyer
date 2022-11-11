<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerLitigations extends Model
{
    use HasFactory;

    //protected $with = ['litigation'];
    
    public function litigation()
    {
        return $this->belongsTo(Litigation::class, 'litigations_id', 'id');
    }


}
