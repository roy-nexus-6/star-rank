<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Celebrity>
 */
class CelebrityFactory extends Factory
{
    protected $model = \App\Models\Celebrity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 名前を組み合わせる例
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName() . ' (' . $this->faker->jobTitle() . ')',

            // 「好き」と「嫌い」の値をランダムにする例
            'like_count' => $this->faker->numberBetween(0, 1000),
            'dislike_count' => $this->faker->numberBetween(0, 500),

            // タイムスタンプ
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
