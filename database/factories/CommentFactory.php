<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Celebrity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'celebrity_id' => Celebrity::inRandomOrder()->first()->id, // ランダムなセレブリティID
            'type' => $this->faker->randomElement(['like', 'dislike']), // タイプ: like または dislike
            'comment' => $this->faker->sentence(10), // ランダムなコメント
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
