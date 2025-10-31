<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'user_id',
    ];

    /**
     * Product belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product belongs to a user (creator)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
