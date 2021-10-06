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
            $table->foreignIdFor(customer::class);
            $table->string('marital_status', 25);
            $table->string('gender', 25);
            $table->string('address_1', 100);
            $table->string('address_2', 100);
            $table->string('city', 25);
            $table->string('state', 25);
            $table->string('pincode', 20);
            $table->string('place_of_birth', 25);
            $table->string('residential_status', 25);
            $table->string('father_name', 50);
            $table->string('mother_name', 50);
            $table->string('pan', 20);
            $table->string('email1', 50);
            $table->string('email2', 50);
            $table->string('aadhar', 20);
            $table->string('primary_nos', 20);
            $table->string('secondary_nos', 20);
            $table->date('dob');
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
