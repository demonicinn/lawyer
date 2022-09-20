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
            
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('lawyer_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('user_cards_id')->nullable();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('user_email', 100);
            $table->string('user_contact', 100);
            $table->date('booking_date');
            $table->time('booking_time');

            $table->enum('appointment_fee', ['free', 'paid']);
            $table->decimal('price', 8,2)->nullable();
            $table->string('zoom_id')->nullable();
            $table->string('zoom_password')->nullable();
            $table->text('zoom_start_url')->nullable();
            $table->enum('is_call', ['pending', 'completed'])->default('pending');
            $table->enum('reschedule', ['0', '1'])->default('0');

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
