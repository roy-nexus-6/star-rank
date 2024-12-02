<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'like_count',
        'dislike_count'
    ];

    public function images()
    {
        return $this->hasMany(CelebrityImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'celebrity_tag', 'celebrity_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
