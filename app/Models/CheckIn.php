<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    protected $fillable = ['reserve_id','type_of_room_id', 'guest_id', 'checkin_date'];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }

    public function typeOfRoom()
    {
        return $this->belongsTo(TypeOfRoom::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
