<?php

namespace App\Models;

use App\Models\Paystacklog;
use App\Models\Tollpoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paystackmodel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function paystacklog()
    {
        return $this->hasMany(Paystacklog::class,'pid');
    }

    public function tollpoint()
    {
        return $this->belongsTo(Tollpoint::class,'pid');
    }
}
