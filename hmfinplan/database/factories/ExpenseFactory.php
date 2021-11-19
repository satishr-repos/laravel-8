<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    private static $index = 0;

    private static $expenses = array('House Hold', 'Monthly', 'Luxury', 'Annual', 'Savings');

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = self::$expenses[self::$index];

        self::$index = (self::$index + 1) % count(self::$expenses);        

        // $category = $this->faker->randomElement($array = array('House Hold', 'Monthly', 'Luxury', 'Annual', 'Savings'));
        if($category == 'House Hold')
            $subCategory = $this->faker->randomElement($array = array('Family Maintenance', 'Children Education', 'Parental Support', 'Transport'));
        elseif($category == 'Monthly')
            $subCategory =  $this->faker->randomElement($array = array('Home Loan Inst', 'Rent', 'Car Loan', 'Credit Card', 'Other'));
        elseif($category == 'Luxury')
            $subCategory =  $this->faker->randomElement($array = array('Life Stlye Expense', 'Unplanned Expenses'));
        elseif($category == 'Annual')
            $subCategory =  $this->faker->randomElement($array = array('Taxes', 'Vehicle Insurance'));
        else
            $subCategory =  $this->faker->randomElement($array = array('Life Insurance', 'Mutual Funds'));

        return [
            'exp_typ' => $category,
            'exp_typ_sub' => $subCategory,
            'annul_exp' => $this->faker->randomFloat(2, 1, 900000),
            'inflation' => $this->faker->randomFloat(2, 2, 10),
            'is_essential' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
