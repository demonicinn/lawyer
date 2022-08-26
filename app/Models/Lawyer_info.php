<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer_info extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
}
