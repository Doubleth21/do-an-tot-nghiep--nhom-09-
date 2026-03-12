<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'booking_id';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'tour_id',
        'schedule_id',
        'booking_date',
        'num_people',
        'total_price',
        'status',
        'payment_status',
        'note',
    ];

    // Relationship: Booking thuộc về Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Relationship: Booking thuộc về Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'tour_id');
    }

    // Relationship: Booking thuộc về DepartureSchedule
    public function schedule()
    {
        return $this->belongsTo(DepartureSchedule::class, 'schedule_id', 'schedule_id');
    }
}
