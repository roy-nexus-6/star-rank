<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelebrityTag extends Model
{
    use HasFactory;

    protected $table = 'celebrity_tag';

    protected $fillable = [
        'celebrity_id',
        'tag_id'
    ];
}
