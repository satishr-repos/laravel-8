<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Goal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'goal_typ' => $this->faker->randomElement($array = array('Home', 'Children Education', 'Children Marriage', 'Vacation', 'Financial Freedom')),
            'goal_desc' => $this->faker->sentence(),
            'goal_start_dt' => $this->faker->dateTimeBetween('-5 years'),
            'goal_target_dt' => $this->faker->dateTimeBetween('+5 years', '+20 years'),
            'current_saving' => $this->faker->randomFloat(2, 100000, 500000),
            'goal_pri' => $this->faker->randomElement($array = array('Low', 'Medium', 'High')),
        ];
    }
}
