<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeApplication extends Model
{
    protected $fillable = [
        'scheme_id',
        'user_id',
        'application_notes',
        'status'
    ];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
