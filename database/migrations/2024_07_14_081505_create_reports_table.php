<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger("category_id");
            $table->foreign('category_id')->references('id')->on('chart_categories');
            $table->string('name'); 
            $table->string('path')->nullable(); 
            $table->string('report_id')->nullable(); 
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
        Schema::dropIfExists('reports');
    }
}
