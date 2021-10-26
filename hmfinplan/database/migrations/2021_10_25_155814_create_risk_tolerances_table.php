<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskTolerancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_tolerances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id');
            $table->foreign('question_id')->references('id')->on('risk_assess_questions')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('risk_assess_answers')->onDelete('cascade');
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
        Schema::dropIfExists('risk_tolerances');
    }
}
