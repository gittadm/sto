<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessCheckboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_checkboxes', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->boolean('is_checked')->default(false);
            $table->unsignedBigInteger('process_task_id');

            $table->foreign('process_task_id')->references('id')->on('process_tasks')
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
        Schema::dropIfExists('process_checkboxes');
    }
}
