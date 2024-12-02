<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\CelebrityRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CelebrityRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CelebrityRelation::factory(50)->create();
    }
}
