<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OauthClientsAddLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // drop unique on id, secret
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->unique(['id', 'secret']);
            $table->string('location');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // add unique on id, secret
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropUnique('oauth_clients_id_secret_unique');
            $table->dropColumn('location');
        });
    }
}
