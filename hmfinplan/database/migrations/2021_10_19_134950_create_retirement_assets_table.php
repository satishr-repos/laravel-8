<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetirementAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retirement_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('acct_typ', 25)->nullable();
            $table->decimal('employe_contrb', 18, 2)->nullable();
            $table->decimal('employr_contrb', 18, 2)->nullable();
            $table->decimal('accmultd_value', 18, 2)->nullable();
            $table->date('strt_yr')->nullable();
            $table->date('end_yr')->nullable();
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
        Schema::dropIfExists('retirement_assets');
    }
}
