<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->id();
            $table->integer('group')->nullable(); 
            $table->string('name');
            $table->integer('required')->nullable();
            $table->integer('valid_interval')->nullable();
            $table->integer('valid_number')->nullable();
            $table->integer('renewal_interval')->nullable();
            $table->integer('renewal_number')->nullable();
            $table->integer('provide_interval')->nullable();
            $table->integer('provide_number')->nullable();
            $table->string('report')->nullable();
            $table->integer('chart_handling')->nullable(); 
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable()->default('1');     
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
        Schema::dropIfExists('charts');
    }
}
