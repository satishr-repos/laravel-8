<?php

namespace Database\Factories;

use App\Models\PensionIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

class PensionIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PensionIncome::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pension_plan' => $this->faker->company(),
            'annul_inc' => $this->faker->randomFloat(2, 1, 9000000),
            'strt_yr' => $this->faker->dateTimeBetween($startDate = '+5 years', $endDate = '+20 years', $timezone = null),
            'end_yr' => $this->faker->dateTimeBetween($startDate = '+10 years', $endDate = '+40 years', $timezone = null),
            'grwth_rt' => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
