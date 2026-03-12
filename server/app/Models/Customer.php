<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Relationship: Customer có nhiều Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id', 'customer_id');
    }
}
