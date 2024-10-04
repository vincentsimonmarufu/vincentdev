<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('flight_id'); 
            $table->string('reference');
            $table->string('queuingOfficeId');
            $table->string('price');
            $table->string('currency');
            $table->string('departure');
            $table->string('arrival');
            $table->string('airline');
            $table->string('carrierCode');
            $table->string('travel_class');
            $table->string('flight_option');
            $table->string('status');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};
