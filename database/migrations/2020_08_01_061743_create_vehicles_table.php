<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('engine_size')->nullable();
            $table->string('fuel_type');
            $table->string('weight')->nullable();
            $table->string('color');
            $table->string('transmission');
            $table->double('price', 8, 2);
            $table->string('status')->default('pending');
            $table->string('badge')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
