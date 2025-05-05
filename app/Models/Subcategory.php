<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'category_id'
    ];

    /**
     * Một subcategory thuộc về một category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Một subcategory có nhiều sản phẩm
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
