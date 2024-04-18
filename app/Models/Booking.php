<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];

    // room list Relationship
    public function assign_rooms(){
        return $this->hasMany(BookingRoomList::class, 'booking_id');
    }

    // user Relationship
    public function user(){
        return $this->belongsTo(User::class);
    }

     // room Relationship
     public function room(){
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }
}
