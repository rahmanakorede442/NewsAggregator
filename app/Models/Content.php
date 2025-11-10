<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';

    protected $fillable = [
        'content_id',
        'source',
        'title',
        'thumbnail_url',
        'content',
        'published_at',
        'language',
        'content_url',
        'author',
        'source',
        'category'
    ];
}
