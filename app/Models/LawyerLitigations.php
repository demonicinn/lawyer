<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerLitigations extends Model
{
    use HasFactory;

    public function litigations()
    {
        return $this->hasOne(Litigation::class, 'id', 'litigations_id');
    }

}
