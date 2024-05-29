<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('phone_type');
            $table->string('extension')->nullable();
            $table->bigInteger('phone_number');
            $table->integer('is_default')->nullable()->default(0);
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
        Schema::dropIfExists('user_phone_numbers');
    }
}
