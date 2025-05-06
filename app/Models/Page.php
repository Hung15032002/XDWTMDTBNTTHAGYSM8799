<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook_link', 
        'zalo_link', 
        'address', 
        'phone_numbers'
    ];

    protected $casts = [
        'phone_numbers' => 'array', // Đảm bảo rằng phone_numbers được lưu dưới dạng mảng JSON
    ];
}
