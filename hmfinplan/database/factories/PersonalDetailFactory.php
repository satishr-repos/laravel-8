<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\PersonalDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonalDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'customer_id' => Customer::pluck('id')[$this->faker->numberBetween(1,Customer::count()-1)],
            'dob' => $this->faker->date($format = 'Y-m-d', $max = '2000-01-01'),
            'marital_status' => $this->faker->randomElement($array = array('Single', 'Married')),
            'gender' => $this->faker->randomElement($array = array('Male', 'Female')),
            'address_1' => $this->faker->streetAddress(),
            'address_2' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pincode' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'place_of_birth' => $this->faker->city(),
            'residential_status' => $this->faker->randomElement($array = array('Indian', 'Non Resident Indian', 'Foreign')),
            'father_name' => $this->faker->name($gender = 'male'),
            'mother_name' => $this->faker->name($gender = 'female'),
            'pan' => $this->faker->regexify('[A-Z]{5}[1-9]{4}[A-Z]'),
            'primary_email' => $this->faker->email(),
            'secondary_email' => $this->faker->companyEmail(),
            'aadhar' => $this->faker->regexify('[1-9]{4}-[0-9]{4}-[0-9]{4}'),
            'primary_nos' => $this->faker->phoneNumber(),
            'secondary_nos' => $this->faker->phoneNumber()
        ];
    }
}
