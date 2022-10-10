<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_answers', function (Blueprint $table) {
            $table->id();
            $table->mediumText('answer')->nullable();
            $table->mediumText('recommendations')->nullable();
            $table->unsignedBigInteger('map_question_id')->nullable();
            $table->timestamps();

            $table->foreign('map_question_id')->references('id')->on('map_questions')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_answers');
    }
}
