<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'document_url',
        'status',
    ];
}
