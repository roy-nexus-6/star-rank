<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Celebrity;
use App\Models\CelebrityRelation;
use App\Models\CelebrityTag;
use App\Models\CelebrityView;
use Illuminate\Cache\TagSet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CelebritySeeder::class,
            CelebrityRelationSeeder::class,
            CelebrityTagSeeder::class,
            CelebrityViewSeeder::class,
            CommentSeeder::class,
            TagSeeder::class,
        ]);
    }
}
