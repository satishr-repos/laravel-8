<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->nullable();
            $table->string('desc', 100)->nullable();
            $table->date('purchase_yr')->nullable();
            $table->integer('purchase_cost')->nullable();
            $table->decimal('expct_growth_rt')->nullable();
            $table->decimal('current_val', 18, 4)->nullable();
		    $table->string('area')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('real_estates');
    }
}
