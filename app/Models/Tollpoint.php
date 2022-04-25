<?php

namespace App\Models;

use App\Models\Tolllanes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tollpoint extends Model
{
    use HasFactory;

    public function tolllanes()
    {
        return $this->belongsToMany(Tolllanes::class);
    }
}
