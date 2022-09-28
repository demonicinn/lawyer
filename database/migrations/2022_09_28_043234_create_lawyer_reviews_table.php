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
        Schema::create('lawyer_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lawyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->decimal('rating', 2,1);
            $table->text('comment');

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
        Schema::dropIfExists('lawyer_reviews');
    }
};
