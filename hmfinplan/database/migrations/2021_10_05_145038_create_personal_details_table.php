<?php

use App\Models\customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(customer::class)->constrained()->onDelete('cascade');
            $table->string('salutation', 20)->nullable();
            $table->string('marital_status', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address_1', 75)->nullable();
            $table->string('address_2', 75)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('place_of_birth', 50)->nullable();
            $table->string('residential_status', 25)->nullable();
            $table->string('father_name', 50)->nullable();
            $table->string('mother_name', 50)->nullable();
            $table->string('pan', 20)->nullable();
            $table->string('primary_email', 50)->nullable();
            $table->string('secondary_email', 50)->nullable();
            $table->string('aadhar', 20)->nullable();
            $table->string('primary_nos', 20)->nullable();
            $table->string('secondary_nos', 20)->nullable();
            $table->date('dob')->nullable();
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
        Schema::dropIfExists('personal_details');
    }
}
