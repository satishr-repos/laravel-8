<?php

namespace Database\Factories;

use App\Models\BankAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'acct_typ' => $this->faker->randomElement($array = array('Savings', 'Current')),
            'desc' => $this->faker->company(50),
            'acct_nbr' => $this->faker->swiftBicNumber(),
            'curr_bal' => $this->faker->randomNumber($nbDigits=8),
            'intrst_rt' => $this->faker->randomFloat(2, 0, 20),
            'status' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
