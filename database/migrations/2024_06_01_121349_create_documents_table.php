<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->integer('chart_id'); 
            $table->date('issue_date')->nullable(); 
            $table->date('renewal_date')->nullable();; 
            $table->string('document_path'); 
            $table->integer('is_deleted')->default(0); 
            $table->timestamps();
            // $table->foreign('chart_id')->references('id')
            //      ->on('charts')->onDelete('cascade'); 
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
