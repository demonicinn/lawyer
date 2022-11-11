<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //protected $with = ['items', 'mainCat'];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }

    public function mainCat()
    {
        return $this->belongsTo(Category::class, 'is_category');
    }

}
