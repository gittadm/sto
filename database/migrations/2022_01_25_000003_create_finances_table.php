<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Finance;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('finance_group_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->enum('operation_type', [Finance::OPERATION_INPUT, Finance::OPERATION_OUTPUT]);
            $table->unsignedInteger('sum');
            $table->timestamps();

            $table->foreign('finance_group_id')->references('id')
                ->on('finance_groups')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('department_id')->references('id')
                ->on('departments')
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
        Schema::dropIfExists('finances');
    }
}
