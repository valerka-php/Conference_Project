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
        Schema::table('reports', function (Blueprint $table) {
           $table->bigInteger('zoom_id')->nullable();
           $table->string('start_url',500)->nullable();
           $table->string('join_url')->nullable();
           $table->smallInteger('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('zoom_id');
            $table->dropColumn('start_url');
            $table->dropColumn('join_url');
            $table->dropColumn('duration');
        });
    }
};
