<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('m_payment_id')->nullable();
            $table->string('pf_payment_id');
            $table->string('status');
            $table->string('item');
            $table->text('description');
            $table->double('amount');
            $table->double('fee');
            $table->double('net');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('merchant_id');
            $table->text('signature');
            $table->string('for');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itn');
    }
}
