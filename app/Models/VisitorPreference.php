<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorPreference extends Model
{

    protected $table = 'visitor_preferences';

    protected $fillable = [
        'visitor_id', 'sources', 'categories', 'authors'
    ];

    protected $casts = [
        'sources' => 'array',
        'authors' => 'array',
        'categories' => 'array',
    ];
}
