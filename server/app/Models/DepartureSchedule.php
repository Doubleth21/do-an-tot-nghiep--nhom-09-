<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureSchedule extends Model
{
    protected $table = 'departure_schedule';
    protected $primaryKey = 'schedule_id';
    public $timestamps = false;

    protected $fillable = [
        'tour_id',
        'departure_date',
        'return_date',
        'available_slots',
        'status',
    ];

    // Relationship: Schedule thuộc về Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'tour_id');
    }

    // Relationship: Schedule có nhiều Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id', 'schedule_id');
    }
}
