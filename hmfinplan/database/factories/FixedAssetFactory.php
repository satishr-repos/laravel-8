<?php

namespace Database\Factories;

use App\Models\FixedAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class FixedAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FixedAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'acct_nbr' => $this->faker->swiftBicNumber(),
            'acct_desc' => $this->faker->company(50),
            'acct_typ' => $this->faker->randomElement($array = array('fixed', 'recurring', 'nsc', 'bond', 'other')),
            'intrst_rt' => $this->faker->randomFloat(2, 0, 20),
            'compound' => $this->faker->randomElement($array = array(true, false)),
            'invest_amt' => $this->faker->randomNumber($nbDigits=8),
            'invest_yr' => $this->faker->date(),
            'maturity_amt' => $this->faker->randomNumber($nbDigits=8),
            'maturity_yr' => $this->faker->date(),
            'status' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
