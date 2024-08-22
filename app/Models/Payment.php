<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['checkout_id', 'amount', 'payment_date'];

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
