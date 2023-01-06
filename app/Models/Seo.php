<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    
    
    protected $appends = [
        'page_name'
    ];

    
    public function getPageNameAttribute()
    {
        $page = ucfirst(str_replace('-', ' ', $this->page));
        
        return $page;
    }
}
