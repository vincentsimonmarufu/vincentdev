<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('seater');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
