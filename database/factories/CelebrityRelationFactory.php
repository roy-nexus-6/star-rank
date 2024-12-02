<?php

namespace Database\Factories;

use App\Models\CelebrityRelation;
use App\Models\Celebrity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CelebrityRelation>
 */
class CelebrityRelationFactory extends Factory
{
    protected $model = CelebrityRelation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // セレブリティIDの取得
        $celebrity1 = Celebrity::inRandomOrder()->first();
        $celebrity2 = Celebrity::inRandomOrder()->where('id', '!=', $celebrity1->id)->first();

        return [
            'celebrity_id_1' => $celebrity1->id,
            'celebrity_id_2' => $celebrity2->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
