<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;

     public function user()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }

}
