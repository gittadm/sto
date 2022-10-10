<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('vin', 20)->unique()->nullable();
            $table->string('number', 20)->unique();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('body')->nullable()->comment('кузов');
            $table->string('color')->nullable();
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('fuel_id')->nullable();
            $table->unsignedBigInteger('engine_volume_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();

            $table->timestamps();

            $table->foreign('fuel_id')->references('id')->on('fuels')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('engine_volume_id')->references('id')->on('engine_volumes')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('client_id')->references('id')->on('clients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_model_id')->references('id')->on('car_models')
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
        Schema::dropIfExists('cars');
    }
}
