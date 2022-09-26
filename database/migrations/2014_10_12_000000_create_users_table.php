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
            $table->string('name');
            $table->string('username')->unique();
            $table->string('fathername')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->unique();
            $table->string('whatsapp')->nullable();
            $table->string('adhar_number')->unique();
            $table->string('pan_number')->nullable();
            $table->string('cv')->nullable();
            $table->string('total_experience');
            $table->string('current_salary')->nullable();
            $table->string('job_profile');
            $table->string('role');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
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
