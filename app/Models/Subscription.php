<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $appends = [
        'types'
    ];

    public function getTypesAttribute(){
        $data = '';
        if($this->type=='monthly'){
            $data = "/mon";
        }
        if($this->type=='yearly'){
            $data = "/yr";
        }

        return $data;
    }

}
