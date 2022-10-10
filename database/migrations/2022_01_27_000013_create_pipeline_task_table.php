<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipelineTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipeline_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('pipeline_id');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->timestamps();

            $table->unique(['task_id', 'pipeline_id']);

            $table->foreign('task_id')->references('id')->on('tasks')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pipeline_id')->references('id')->on('pipelines')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pipeline_task');
    }
}
