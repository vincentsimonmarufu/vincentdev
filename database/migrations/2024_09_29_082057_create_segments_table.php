<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            //
            // Foreign key to flight_bookings
            $table->foreignId('flight_booking_id')->constrained('flight_bookings')->onDelete('cascade');
            
            // Flight segment details
            $table->string('departure_iata', 3);
            $table->string('arrival_iata', 3);
            $table->string('departure_terminal')->nullable();
            $table->string('arrival_terminal')->nullable();
            $table->dateTime('departure_date_time');
            $table->dateTime('arrival_date_time');
            $table->string('carrier_code', 2); 
            $table->string('aircraft_number');           
            $table->string('flight_number');
            $table->integer('number_of_stops')->default(0);
            $table->string('duration'); 
            //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
