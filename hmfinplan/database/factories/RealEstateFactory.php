<?php

namespace Database\Factories;

use App\Models\RealEstate;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealEstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RealEstate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement($array = array('land', 'house', 'apartment')),
            'desc' => $this->faker->streetAddress(),
		    'area' => $this->faker->randomNumber($nbDigits=5),
            'purchase_yr' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
            'purchase_cost' => $this->faker->randomNumber($nbDigits=7),
            'expct_growth_rt' => $this->faker->randomFloat(2, 0, 20),
            'current_val' => $this->faker->randomFloat(2, 0, null),
            'status' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
