<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }

    public function notes()
    {
        return $this->hasOne(Note::class);
    }
}
