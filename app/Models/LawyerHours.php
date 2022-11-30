<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerHours extends Model
{
    use HasFactory;

    protected $appends = [
        'days', 'days_array'
    ];

    public function getDaysAttribute()
    {
        if(@$this->day){
            $days = json_decode($this->day);

            $days = implode(', ', $days);
            return $days;
        }

        return [];
    }


    public function getDaysArrayAttribute()
    {
        if(@$this->day){
            $days = json_decode($this->day);
            return $days;
        }

        return [];
    }
}
