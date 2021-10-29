<?php

namespace Database\Factories;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsuranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insurance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'polcy_typ' => $this->faker->randomElement($array = array('Annuity', 'Medical', 'Endowment', 'Money Back', 'Term Plan', 'ULIP', 'Whole Life')),
            'insurnce_cmpny' => $this->faker->company(),
            'polcy_name' => $this->faker->sentence(),
            'polcy_nbr' => $this->faker->swiftBicNumber(),
            'insuree_name' => $this->faker->name(),
            'polcy_start_dt' => $this->faker->dateTimeBetween('-10 years'),
            'polcy_end_dt' => $this->faker->dateTimeBetween('+5 years', '+20 years'),
            'sum_insurd' => $this->faker->randomFloat(2, 100000, 9000000),
            'annul_prmium' => $this->faker->randomFloat(2, 10000, 100000),
            'prmium_mode' => $this->faker->randomElement($array = array('Monthly', 'Quarterly', 'Half Yearly', 'Annual')),
        ];
    }
}
