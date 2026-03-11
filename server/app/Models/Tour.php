<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * Các hướng dẫn viên được phân công cho tour.
     */
    public function guides(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tour_guides', 'tour_id', 'user_id')
            ->withPivot(['assigned_at']);
    }
}
