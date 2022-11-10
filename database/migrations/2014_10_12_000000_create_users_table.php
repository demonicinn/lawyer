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
        Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();

            $table->enum('role', ['admin', 'lawyer', 'user'])->default('lawyer');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->string('image')->nullable();
            $table->string('contact_number')->nullable();
			$table->enum('profile_completed', ['0', '1'])->default('0');
            $table->enum('status', ['0', '1', '2'])->default('1');
            $table->enum('auto_renew', ['0', '1'])->default('1');
            $table->string('payment_plan')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'role' => 'admin',
            'first_name' => 'Jhon',
            'last_name' => 'Wick',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('12345678')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
