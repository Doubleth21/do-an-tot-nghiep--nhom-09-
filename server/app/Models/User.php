<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    // Phân quyền người dùng
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_TOUR_GUIDE = 'tour_guide';
    const ROLE_LIST = [
        self::ROLE_ADMIN,
        self::ROLE_USER,
        self::ROLE_TOUR_GUIDE,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'fullname',
        'email',
        'phone',
        'role',
        'status',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Mặc định khi đăng ký tài khoản phải có role là user
    protected $attributes = [
        'role' => self::ROLE_USER,
    ];

    //Kiểm tra xem người dùng có phải là ROLE_ADMIN hay không
    public function isRoleAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }

    // Kiểm tra xem người dùng có phải là ROLE_TOUR_GUIDE hay không
    public function isRoleTourGuide(){
        return $this->role === self::ROLE_TOUR_GUIDE;
    }

    // Kiểm tra xem người dùng có phải là admin hoặc tour guide (dùng để vào trang quản lý)
    public function isAdmin(){
        return $this->isRoleAdmin() || $this->isRoleTourGuide();
    }

    // Kiểm tra xem người dùng có phải là user thường hay không
    public function isRegularUser(){
        return $this->role === self::ROLE_USER;
    }
}
