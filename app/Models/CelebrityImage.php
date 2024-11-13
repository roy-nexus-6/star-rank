<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelebrityImage extends Model
{
    use HasFactory;

    protected $fillable = ['celebrity_id', 'image_path'];

    /**
     * 芸能人とのリレーション (多対1)
     */
    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }
}
