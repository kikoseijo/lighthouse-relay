<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OAuthSeeder extends Seeder {

    public function run()
    {
        app()->configure('secrets');

        $config = app()->make('config');

        $db = app()->make('db');
        /* @var $db Illuminate\Database\DatabaseManager */

        $connection = $db->connection();
        /* @var $connection Illuminate\Database\MySqlConnection */

        $connection->statement('SET FOREIGN_KEY_CHECKS=0');

        // clear the users table first
        $db->table('api_users')->delete();

        // clear client location table
        $db->table('api_client_locations')->delete();

        // clear all relevant oauth tables
        $db->table('oauth_clients')->delete();

        $clients = $config->get('secrets.clients');
        if (is_array($clients)) {

            $locations = [];

            foreach ($clients as $id => $client) {

                $db->table('oauth_clients')->insert([
                    'id' => $client['id'],
                    'secret' => $client['secret'],
                    'name' => $client['name'],
                    'password_client' => true,
                    'location' => isset($client['location']) ? $client['location'] : '',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]);

                if (isset($client['location']) && $client['location']) {
                    foreach (explode(',', $client['location']) as $locationId) {

                        // check if location record exists, if not create it
                        if (! $db->table('api_locations')->find($locationId)) {
                            $db->table('api_locations')->insert([
                                'id' => $locationId
                            ]);
                        }
                        $db->table('api_client_locations')->insert([
                            'client_id' => $client['id'],
                            'location_id' => $locationId
                        ]);
                    }
                }

            }

        }

        $connection->statement('SET FOREIGN_KEY_CHECKS=1');

    }

}
