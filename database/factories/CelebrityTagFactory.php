<?php

namespace Database\Factories;

use App\Models\Celebrity;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CelebrityTag>
 */
class CelebrityTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'celebrity_id' => Celebrity::inRandomOrder()->first()->id, // ランダムなセレブリティID
            'tag_id' => Tag::inRandomOrder()->first()->id, // ランダムなタグID
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
