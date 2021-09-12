<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LGA extends Model
{
    use HasFactory;

    public function polling_units(){
        return $this->hasMany(PollingUnit::class);
    }
    public function announced(){
        return $this->hasOne(AnnouncedLgaResult::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
}
