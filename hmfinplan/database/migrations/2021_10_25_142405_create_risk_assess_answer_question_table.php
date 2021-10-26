<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAssessAnswerQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_assess_answer_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('risk_assess_question_id');
            $table->unsignedBigInteger('risk_assess_answer_id');
            $table->foreign('risk_assess_question_id')->references('id')->on('risk_assess_questions')->onDelete('cascade');
            $table->foreign('risk_assess_answer_id')->references('id')->on('risk_assess_answers')->onDelete('cascade');
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
        Schema::dropIfExists('risk_assess_answer_question');
    }
}
