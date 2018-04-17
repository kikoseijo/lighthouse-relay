<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomsNestedSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_rooms', function(Blueprint $table)
        {
            $table->integer('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // drop nested set columns
        Schema::table('api_rooms', function (Blueprint $table) {
            $table->dropColumn(['parent_id', 'lft', 'rgt', 'level']);
        });
    }
}
