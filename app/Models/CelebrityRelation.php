<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelebrityRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'celebrity_id_1',
        'celebrity_id_2',
    ];

    // セレブリティ1とのリレーション
    public function celebrity1()
    {
        return $this->belongsTo(Celebrity::class, 'celebrity_id_1');
    }

    // セレブリティ2とのリレーション
    public function celebrity2()
    {
        return $this->belongsTo(Celebrity::class, 'celebrity_id_2');
    }
}
