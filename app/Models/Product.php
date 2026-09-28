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
        'category',
        'description',
        'price',
        'specs',
        'image_url',
        'images',
    ];

    protected $casts = [
        'specs' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
    ];
}
