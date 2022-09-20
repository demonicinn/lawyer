<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

	protected $appends = [
        'zoom_zak'
    ];

    public function getZoomZakAttribute(){
    	parse_str(parse_url($this->zoom_start_url, PHP_URL_QUERY), $result);
		if(@$result['zak']){
			return $link = $result['zak'];
		}
		return '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notes()
    {
        return $this->hasOne(Note::class);
    }
}
