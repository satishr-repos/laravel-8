<?php

namespace Database\Factories;

use App\Models\InvestmentAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvestmentAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'stk_typ' => $this->faker->randomElement($array = array('debt', 'equity')),
            'isin_nbr' => $this->faker->regexify('[A-Z]{2}[0-9A-Z]{10}'),
            'stk_dtl' => $this->faker->company(50),
            'units_held' => $this->faker->randomFloat(4, 1, 10000),
            'purchse_cst' => $this->faker->randomFloat(4, 1, 1000000),
            'currnt_val' => $this->faker->randomFloat(4, 1, 10000000),
            'status' => $this->faker->randomElement($array = array(true, false)),
            //
        ];
    }
}
