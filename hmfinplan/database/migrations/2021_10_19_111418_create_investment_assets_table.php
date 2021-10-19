<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('stk_typ', 20)->nullable();
            $table->string('isin_nbr', 20)->nullable();
            $table->string('stk_dtl', 100)->nullable();
            $table->decimal('units_held', 18, 4)->nullable();
            $table->decimal('purchse_cst', 18, 4)->nullable();
            $table->decimal('currnt_val', 18, 4)->nullable();
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
        Schema::dropIfExists('investment_assets');
    }
}
