<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('loan_typ',25)->nullable();
            $table->string('fin_inst',250)->nullable();
            $table->decimal('amt_outstanding',18,2)->nullable();
            $table->decimal('emi',18,2)->nullable();
            $table->decimal('inrst_rt',18,2)->nullable();
            $table->date('start_yr')->nullable();
            $table->integer('duration')->nullable();
 	        $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('liabilities');
    }
}
