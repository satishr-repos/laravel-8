<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'goal_desc' => $this->faker->sentence(3, false),
            'goal_start_dt' => Carbon::now()->format('Y-m-d'), 
            'goal_target_dt' => $this->faker->dateTimeBetween('+5 years', '+20 years'),
            'current_cost' => $this->faker->randomFloat(2, 100000, 1000000),
            'goal_pri' => $this->faker->randomElement($array = array('Low', 'Medium', 'High')),
            'inflation' => $this->faker->randomFloat(2, 2, 10),
        ];
    }
}
