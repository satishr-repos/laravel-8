<?php

use App\Models\customer;
use App\Models\FamilyMember;
use App\Models\RetirementAsset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->decimal('gross_salry',18,2)->nullable();
            $table->decimal('net_salry',18,2)->nullable();
            $table->decimal('basic_salry',18,2)->nullable();
            $table->decimal('grwth_rt',10,2)->nullable();
            $table->foreignIdFor(RetirementAsset::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(FamilyMember::class)->nullable()->constrained()->onDelete('set null');
            // $table->foreign('epf_id')->references('id')->on('retirement_assets')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_incomes');
    }
}
