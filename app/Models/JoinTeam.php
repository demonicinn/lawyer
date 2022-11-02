<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinTeam extends Model
{
    use HasFactory;

    protected $appends = [
        'resume_path'
    ];

    public function getResumePathAttribute()
    {
        if ($this->resume) {
            return asset('storage/resume/' . $this->resume);
        }
        return '';
    }

}


