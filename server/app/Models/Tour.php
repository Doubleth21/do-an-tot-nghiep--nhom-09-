<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';
    protected $primaryKey = 'tour_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tour_name',
        'description',
        'price',
        'duration',
        'max_participants',
        'start_date',
        'end_date',
        'location',
        'image',
        'status',
        'category_id',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Trạng thái tour
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const STATUS_LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    // Mặc định tour có trạng thái active
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    // Relationship với User (người tạo tour)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Relationship với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // Scope để lọc tour theo trạng thái
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    // Kiểm tra tour có đang hoạt động không
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    // Kiểm tra tour đã hoàn thành chưa
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // Get image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}