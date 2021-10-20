<?php

namespace Database\Factories;

use App\Models\Liability;
use Illuminate\Database\Eloquent\Factories\Factory;

class LiabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Liability::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'loan_typ' => $this->faker->randomElement($array = array('house', 'car', 'personal')),
            'fin_inst' => $this->faker->company(50),
            'amt_outstanding' => $this->faker->randomFloat(2, 0, 99999999),
            'inrst_rt' => $this->faker->randomFloat(2, 0, 20),
            'emi' => $this->faker->randomFloat(2, 0, 999999),
            'start_yr' => $this->faker->date(),
            'duration' => $this->faker->randomNumber($nbDigits=3),
            'status' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
