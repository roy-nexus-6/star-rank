<?php

namespace Database\Factories;

use App\Models\Celebrity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CelebrityView>
 */
class CelebrityViewFactory extends Factory
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
            'view_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'), // 過去1か月から今日までのランダムな日付
            'view_count' => $this->faker->numberBetween(1, 500), // 1～500のランダムな閲覧数
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
