<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerContracts extends Model
{
    use HasFactory;

    //protected $with = ['contract'];

    public function contract()
    {
        return $this->belongsTo(Litigation::class, 'contracts_id','id');
    }
}
