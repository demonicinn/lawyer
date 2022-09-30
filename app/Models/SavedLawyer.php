<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedLawyer extends Model
{
    use HasFactory;

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }

    public function lawyerCategory()
    {
        return $this->hasOne(Lawyer_info::class, 'user_id', 'lawyer_id');
    }

    public function lawyerInfo()
    {
        return $this->hasMany(Lawyer_info::class, 'user_id', 'lawyer_id');
    }
}
