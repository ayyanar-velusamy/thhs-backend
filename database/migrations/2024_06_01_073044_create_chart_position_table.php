<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_position', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('chart_id');
            $table->unsignedBiginteger('position_id'); 

            $table->foreign('chart_id')->references('id')
                 ->on('charts')->onDelete('cascade');
            $table->foreign('position_id')->references('id')
                ->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chart_position');
    }
}
