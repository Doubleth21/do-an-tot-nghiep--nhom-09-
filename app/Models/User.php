<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false; // we will handle timestamps via DB defaults

    protected $fillable = [
        'username',
        'password',
        'fullname',
        'email',
        'phone',
        'role',
        'status',
        'created_at',
        'updated_at',
    ];
}
