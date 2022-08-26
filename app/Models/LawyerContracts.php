<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerContracts extends Model
{
    use HasFactory;

    public function contracts()
    {
        return $this->hasOne(Litigation::class, 'id', 'contracts_id');
    }
}
