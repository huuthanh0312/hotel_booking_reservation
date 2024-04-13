<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    //connection key roomtype and room by id
    public function type(){
        return $this->belongsTo(RoomType::class, "roomtype_id", "id");
    }

    public function room_numbers(){
        return $this->hasMany(RoomNumber::class, "rooms_id", "id")->where('status', 'active');
    }
}
