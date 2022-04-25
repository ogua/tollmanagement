<?php

namespace App\Models;

use App\Models\Tollpoint;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivetran extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function tollpoint()
    {
        return $this->belongsTo(Tollpoint::class,'reference');
    }


    public function user()
    {
        return $this->belongsTo(Administrator::class,'receivedbyid');
    }




}
