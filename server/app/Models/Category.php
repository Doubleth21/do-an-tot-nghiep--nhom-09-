<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'category_name',
        'description',
        'status'
    ];

    // Trạng thái category
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    // Mặc định category có trạng thái active
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    // Relationship với Tour
    public function tours()
    {
        return $this->hasMany(Tour::class, 'category_id', 'category_id');
    }

    // Scope để lọc category theo trạng thái
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Kiểm tra category có đang hoạt động không
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}