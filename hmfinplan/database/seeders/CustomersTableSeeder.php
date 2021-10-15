<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\FamilyMember;
use App\Models\PersonalDetail;
use App\Models\ProfessionalDetails;

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
            ->count(10)
            ->has(PersonalDetail::factory()->count(1))
            ->has(FamilyMember::factory()->count(4))
            ->has(ProfessionalDetails::factory()->count(2))
            ->create();
    }
}
