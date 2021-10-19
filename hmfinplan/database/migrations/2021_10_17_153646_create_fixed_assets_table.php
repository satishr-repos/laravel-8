<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('acct_nbr', 50)->nullable();
            $table->string('acct_desc', 50)->nullable();
            $table->string('acct_typ', 50)->nullable();
            $table->decimal('intrst_rt', 6, 2)->nullable();
            $table->tinyInteger('compound')->nullable();
            $table->decimal('invest_amt', 18, 4)->nullable();
            $table->date('invest_yr')->nullable();
            $table->date('maturity_yr')->nullable();
            $table->decimal('maturity_amt', 18,4)->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('fixed_assets');
    }
}
