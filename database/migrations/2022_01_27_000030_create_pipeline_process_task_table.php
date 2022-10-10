<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipelineProcessTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipeline_process_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_task_id');
            $table->unsignedBigInteger('pipeline_id');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->string('status', 20);
            $table->timestamps();

            $table->unique(['process_task_id', 'pipeline_id']);

            $table->foreign('process_task_id')->references('id')->on('process_tasks')
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
        Schema::dropIfExists('pipeline_process_task');
    }
}
