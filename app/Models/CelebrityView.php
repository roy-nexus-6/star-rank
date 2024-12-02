<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelebrityView extends Model
{
    use HasFactory;

    protected $fillable = ['celebrity_id', 'view_date', 'view_count'];

    /**
     * セレブリティとのリレーション
     */
    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class, 'celebrity_id');
    }
}
