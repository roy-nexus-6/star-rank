<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CelebrityTag;

class CelebrityTagSeeder extends Seeder
{
    public function run()
    {
        CelebrityTag::factory()->count(50)->create(); // 50件のデータを生成
    }
}
