<?php

namespace Database\Factories;

use App\Models\SalaryIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryIncome::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gross_salry' => $this->faker->randomFloat(2, 1, 10000000),
            'net_salry' => $this->faker->randomFloat(2, 1, 9000000),
            'grwth_rt' => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
