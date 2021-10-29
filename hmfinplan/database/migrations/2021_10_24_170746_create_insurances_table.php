<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('polcy_typ', 50)->nullable();
            $table->string('insurnce_cmpny', 150)->nullable();
            $table->string('polcy_name', 255)->nullable();
            $table->string('polcy_nbr', 50)->nullable();
            $table->string('insuree_name', 100)->nullable();
            $table->date('polcy_start_dt')->nullable();
            $table->date('polcy_end_dt')->nullable();
            $table->decimal('sum_insurd', 18, 2)->nullable();
            $table->decimal('annul_prmium', 18, 2)->nullable();
            $table->string('prmium_mode', 50)->nullable();
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
        Schema::dropIfExists('insurances');
    }
}
