<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('inc_typ',50)->nullable();
            $table->string('inc_desc',255)->nullable();
            $table->decimal('annul_inc',18,2)->nullable();
            $table->decimal('inc_tx_rt',8,2)->nullable();
            $table->decimal('grwth_rt',10,2)->nullable();
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
        Schema::dropIfExists('other_incomes');
    }
}
