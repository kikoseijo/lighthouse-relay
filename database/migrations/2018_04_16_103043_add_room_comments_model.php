<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomCommentsModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // lightspeed product table
        Schema::create('api_room_comments', function(Blueprint $table)
        {

            // columns
            $table->increments('id');
            $table->unsignedInteger('room_id')->nullable();
            $table->string('reference', 63)->uuid();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestampsTz();

            // indexes
            $table->foreign('room_id')->references('id')->on('api_rooms');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // drop indexes
        Schema::table('api_room_comments', function (Blueprint $table) {
            $table->dropForeign('api_room_comments_room_id_foreign');
        });

        // drop tables
        Schema::drop('api_room_comments');

    }
}
