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
            'gross_salry' => $this->faker->randomFloat(2, 3000000, 5000000),
            'net_salry' => $this->faker->randomFloat(2, 2000000, 4000000),
            'basic_salry' => $this->faker->randomFloat(2, 1000000, 2000000),
            'grwth_rt' => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
