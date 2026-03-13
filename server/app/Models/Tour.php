<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DepartureSchedule;

class Tour extends Model
{
    protected $table = 'tour';
    protected $primaryKey = 'tour_id';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'policy',
        'supplier',
        'image',
        'status',
        'price',
    ];

    public function departureSchedules()
    {
        return $this->hasMany(DepartureSchedule::class, 'tour_id', 'tour_id');
    }
}
