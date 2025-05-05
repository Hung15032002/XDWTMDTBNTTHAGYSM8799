<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'code',
        'qty',
        'subcategory_id',
        'brand_id',
        'status',
        'origin', 
        'material', 
        'dimensions', 
        'color', 
        'warranty'
    ];

    // Mối quan hệ với Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Mối quan hệ với Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
