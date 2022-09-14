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
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('lawyer_id');
            $table->string('card_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('user_email', 100);
            $table->string('user_contact', 100);
            $table->string('booking_date', 100);
            $table->string('booking_time', 100);
            $table->enum('appointment_fee', ['free', 'paid']);
            $table->integer('price')->nullable();
            $table->string('zoom_id')->nullable();
            $table->string('zoom_password')->nullable();
            $table->enum('is_call', ['pending', 'completed'])->default('pending');
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
        Schema::dropIfExists('bookings');
    }
};
