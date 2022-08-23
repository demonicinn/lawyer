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
        Schema::create('user_details', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('states_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('city', 100);
            $table->string('zip_code', 20);

            $table->text('bio')->nullable();
            $table->enum('contingency_cases', ['yes', 'no'])->default('no');
            $table->enum('is_consultation_fee', ['yes', 'no'])->default('no');
            $table->decimal('hourly_fee', 8,2)->nullable();
            $table->decimal('consultation_fee', 8,2)->nullable();
            $table->string('website_url')->nullable();
            $table->text('address')->nullable();
            $table->string('bar_number')->nullable();
            $table->string('year_admitted')->nullable();
            $table->string('year_experience')->nullable();

            $table->enum('is_verified', ['yes', 'no'])->default('no');
            $table->enum('is_admin_review', ['0', '1', '2'])->default('0');
            $table->enum('review_request', ['0', '1'])->default('0');
            
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
        Schema::dropIfExists('user_details');
    }
};
