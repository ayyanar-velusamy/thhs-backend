<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('birth_date')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('language_id')->nullable();
            $table->integer('ssn')->nullable();
            $table->string('employeement_authorization')->nullable();
            $table->string('corporation_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('position')->nullable(); 
            $table->string('tax_id')->nullable(); 
            $table->text('address')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('city')->nullable(); 
            $table->string('zip')->nullable(); 
            $table->integer('phone_home')->nullable(); 
            $table->string('business')->nullable(); 
            $table->integer('cellular')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('start_date')->nullable();
            $table->integer('has_convicted_felony')->nullable();
            $table->string('convicted_reason')->nullable();
            $table->integer('has_reviwed_job_description')->nullable();
            $table->integer('can_perform_without_accomodation')->nullable();
            $table->text('special_skills')->nullable();
            $table->integer('had_influeza_vaccine')->nullable();
            $table->date('influeza_vaccine_date')->nullable();
            $table->string('influeza_vaccine_reason')->nullable();
            $table->integer('had_hepatitis_vaccine')->nullable();
            $table->date('hepatitis_vaccine_date')->nullable();
            $table->string('hepatitis_vaccine_reason')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('is_admin')->default('0'); 
            $table->integer('status')->default('0'); 
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
