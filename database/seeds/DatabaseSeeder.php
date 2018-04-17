<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // OAuth seeder
        $this->call('OAuthSeeder');

        // User seeder
        $this->call('UserSeeder');

        Model::reguard();
    }
}
