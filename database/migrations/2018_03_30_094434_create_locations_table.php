<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_locations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('reference', 63)->uuid()->nullable();
            $table->string('name', 127)->nullable();
            $table->string('email', 127)->nullable();
            $table->string('details')->nullable();
            });

        Schema::create('api_client_locations', function(Blueprint $table)
        {
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('location_id');
            $table->primary(['client_id', 'location_id']);
            $table->foreign('client_id')->references('id')->on('oauth_clients');
            $table->foreign('location_id')->references('id')->on('api_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // drop indexes from table
        Schema::table('api_client_locations', function (Blueprint $table) {
            $table->dropForeign('api_client_locations_client_id_foreign');
            $table->dropForeign('api_client_locations_location_id_foreign');
        });

        Schema::drop('api_client_locations');
        Schema::drop('api_locations');
    }
}
