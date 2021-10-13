<?php

namespace Database\Factories;

use App\Models\ProfessionalDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessionalDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfessionalDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'employer' => $this->faker->company(),
            'education' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'preferred_time' => $this->faker->randomElement($array = array('morning', 'noon', 'evening', 'night')),
        ];
    }
}
