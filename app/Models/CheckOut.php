<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    protected $fillable = ['reserve_id', 'type_of_room_id', 'guest_id', 'checkout_date'];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

}
