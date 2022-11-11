<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer_info extends Model
{
    use HasFactory;

    //protected $with = ['categories', 'items'];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
