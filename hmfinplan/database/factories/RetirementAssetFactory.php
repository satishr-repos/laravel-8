<?php

namespace Database\Factories;

use App\Models\RetirementAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetirementAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RetirementAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'acct_typ' => $this->faker->randomElement($array = array('epf', 'ppf')),
            'employe_contrb' => $this->faker->randomFloat(4, 1, 100000),
            'employr_contrb' => $this->faker->randomFloat(4, 1, 100000),
            'accmultd_value' => $this->faker->randomFloat(4, 1, 9000000),
            'strt_yr' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = '-10 years', $timezone = null),
            'end_yr' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null),
        ];
    }
}
