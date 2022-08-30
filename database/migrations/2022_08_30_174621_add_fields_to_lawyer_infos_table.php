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
        Schema::table('lawyer_infos', function (Blueprint $table) {
            //...
            $table->string('year_admitted')->nullable();
            $table->string('bar_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawyer_infos', function (Blueprint $table) {
            //...
            $table->dropColumn('year_admitted');
            $table->dropColumn('bar_number');
        });
    }
};
