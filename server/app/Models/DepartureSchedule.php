<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureSchedule extends Model
{
    protected $table = 'departure_schedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = true;

    protected $fillable = [
        'tour_id',
        'departure_date',
        'end_date',
        'capacity',
        'booked',
        'price',
        'status',
        'note',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'tour_id');
    }
}

