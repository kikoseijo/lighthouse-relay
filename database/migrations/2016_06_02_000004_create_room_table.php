<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_rooms', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->boolean('available')->index();
            $table->string('reference');
            $table->text('details');
            $table->integer('sort');
            $table->string('location')->default("1")->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('api_rooms');
    }
}
