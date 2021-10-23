<?php

namespace Database\Factories;

use App\Models\OtherIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtherIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OtherIncome::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'inc_typ' => $this->faker->word(),
            'inc_desc' => $this->faker->sentence(),
            'annul_inc' => $this->faker->randomFloat(2, 1, 9000000),
            'inc_tx_rt' => $this->faker->randomFloat(2, 1, 50),
            'grwth_rt' => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
