<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'guest_id', 'checkin_date', 'checkout_date', 'total_amount'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function checkins()
    {
        return $this->hasMany(CheckIn::class);
    }

    public function checkout()
    {
        return $this->hasOne(CheckOut::class);
    }
}
