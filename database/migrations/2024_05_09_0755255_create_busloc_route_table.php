<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        
        Schema::create('busloc_route', function (Blueprint $table) {
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('order');
            $table->unsignedSmallInteger('minutes_from_departure');
            $table->unsignedSmallInteger('prices_from_departure');            
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('busloc_route');
    }
};