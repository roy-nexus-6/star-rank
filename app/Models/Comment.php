<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'celebrity_id',
        'type',
        'comment',
        'parent_id',
    ];

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }
}
