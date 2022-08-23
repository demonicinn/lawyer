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
        Schema::create('lawyer_subscriptions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('subscriptions_id')->references('id')->on('subscriptions')->onDelete('cascade');

            $table->bigInteger('payments_id')->nullable();

            $table->date('from_date');
            $table->date('to_date');

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
        Schema::dropIfExists('lawyer_subscriptions');
    }
};
