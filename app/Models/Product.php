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
        'category',
        'status',
        'user_id',
        'image',
        'is_featured',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
