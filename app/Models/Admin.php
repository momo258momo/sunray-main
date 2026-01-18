<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Ẩn thuộc tính không cần thiết trong quá trình serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Các thuộc tính cần cast về định dạng
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}