<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
