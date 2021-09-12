<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollingUnit extends Model
{
    use HasFactory;

    public function agents(){
        return $this->hasMany(Agent::class);
    }
    public function ward(){
        return $this->belongsTo(Ward::class);
    }
    public function lga(){
        return $this->belongsTo(LGA::class);
    }
}
