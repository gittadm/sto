<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessCategoryProcessTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_category_process_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_task_id');
            $table->unsignedBigInteger('process_category_id');

            $table->foreign('process_task_id')->references('id')->on('process_tasks')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('process_category_id')->references('id')->on('process_categories')
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
        Schema::dropIfExists('process_category_process_task');
    }
}
