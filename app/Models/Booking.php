<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'zoom_id'
    ];

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

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }

    public function notes()
    {
        return $this->hasOne(Note::class);
    }

    public function cardDetails()
    {
        return $this->belongsTo(UserCard::class, 'user_cards_id', 'id');
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
