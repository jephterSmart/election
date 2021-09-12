<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    public function polling_units(){
        return $this->hasMany(PollingUnit::class);
    }
    public function lga(){
        return $this->belongsTo(LGA::class);
    }
    
}
