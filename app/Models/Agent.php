<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public function polling_unit(){
        return $this->belongsTo(PollingUnit::class);
    }
    public function announcerLga(){
        return $this->hasMany(AnnouncedLgaResult::class);
    }
    public function announcerPu(){
        return $this->hasMany(AnnouncePuResult::class);
    }
}
