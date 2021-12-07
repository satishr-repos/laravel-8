<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FamilyMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->word(),
            'last_name' => $this->faker->lastName(),
            'salutation' => $this->faker->title(),
            'pan' => $this->faker->regexify('[A-Z]{5}[1-9]{4}[A-Z]'),
            'dob' => $this->faker->date($format = 'Y-m-d'),
            'relation' => $this->faker->randomElement($array = array('Spouse', 'Son', 'Daughter', 'Others')),
            'wedding_date' => $this->faker->date($format = 'Y-m-d'),
            //
        ];
    }
}
