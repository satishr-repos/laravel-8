<?php

namespace Database\Factories;

use App\Models\RentalIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RentalIncome::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'annul_inc' => $this->faker->randomFloat(2, 1, 100000),
            'grwth_rt' => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
