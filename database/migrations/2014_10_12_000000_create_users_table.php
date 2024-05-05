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
            $table->integer('gender')->default('1');
            $table->integer('language_id')->nullable();
            $table->integer('ssn')->nullable();
            $table->string('employement_authorization')->nullable();
            $table->string('corporation_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->integer('position')->nullable(); 
            $table->string('tax_id')->nullable(); 
            $table->text('address')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('city')->nullable(); 
            $table->string('zip')->nullable(); 
            $table->bigInteger('phone_home')->nullable(); 
            $table->string('business')->nullable(); 
            $table->bigInteger('cellular')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('resume_path')->nullable(); 
            $table->string('start_date')->nullable();
            $table->integer('has_convicted_felony')->nullable();
            $table->string('convicted_reason')->nullable();
            $table->integer('has_reviewed_job_description')->nullable();
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
            $table->integer('role')->default('1'); 
            $table->integer('status')->default('0'); 
            $table->integer('organization')->default('1');   
            $table->date('termination_date')->nullable(); 
            $table->dateTime('interview_schedule_date')->nullable(); 
            $table->date('interview_confirm_date')->nullable(); 
            $table->date('hire_date')->nullable(); 
            $table->integer('prospect_status')->nullable(); 
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
