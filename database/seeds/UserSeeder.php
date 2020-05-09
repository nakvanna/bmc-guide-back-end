<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "anana",
            'email' => "nakvanna@gmail.com",
            'password' => Hash::make('vanna@love4you'),
            'type_user' => "1",
            'status' => "true",
        ]);
    }
}
