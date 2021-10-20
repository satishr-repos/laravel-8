<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\FamilyMember;
use App\Models\PersonalDetail;
use App\Models\PersonalItem;
use App\Models\ProfessionalDetails;
use App\Models\RealEstate;
use App\Models\BankAsset;
use App\Models\FixedAsset;
use App\Models\InvestmentAsset;
use App\Models\Liability;
use App\Models\RetirementAsset;

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
            ->has(RealEstate::factory()->count(4))
            ->has(PersonalItem::factory()->count(5))
            ->has(BankAsset::factory()->count(3))
            ->has(FixedAsset::factory()->count(4))
            ->has(InvestmentAsset::factory()->count(4))
            ->has(RetirementAsset::factory()->count(3))
            ->has(Liability::factory()->count(3))
            ->create();
    }
}
