<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncePuResult extends Model
{
    use HasFactory;
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
    public function polling_unit(){
        return $this->belongsTo(PollingUnit::class);
    }
}
