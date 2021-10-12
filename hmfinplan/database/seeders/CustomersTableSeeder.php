<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\FamilyMember;
use App\Models\PersonalDetail;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
            ->count(50)
            ->has(PersonalDetail::factory()->count(1))
            ->has(FamilyMember::factory()->count(4))
            ->create();
    }
}
