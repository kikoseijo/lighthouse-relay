<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder {

    public function run()
    {

        app()->configure('secrets');

        $config = app()->make('config');
        $db = app()->make('db');

        // clear tables
        $db->table('api_users')->delete();

        // get data from config
        $users = $config->get('secrets.users');
        $clients = $config->get('secrets.clients');

        // insert users
        if (is_array($users)) {

            foreach ($users as $email => $data) {

                $data['client_id'] = $clients[$data['client_id']]['id'];

                $user = app()->make(\App\Models\User::class);

                $user->fill(array_merge($data, array('email' => $email, 'password' => $data['password'])));

                $user->save();

            }
        }
    }

}
