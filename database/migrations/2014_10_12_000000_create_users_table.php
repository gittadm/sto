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
            $table->string('surname')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->date('born_at')->nullable();
            $table->string('office_position')->nullable();
            $table->text('about')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_about_visible');
            $table->boolean('is_born_at_visible');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->datetime('login_at')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')
                ->onUpdate('cascade')->onDelete('restrict');
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
