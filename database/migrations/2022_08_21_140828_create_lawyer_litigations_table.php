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
        Schema::create('lawyer_litigations', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('litigations_id')->references('id')->on('litigations')->onDelete('cascade');

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
        Schema::dropIfExists('lawyer_litigations');
    }
};
