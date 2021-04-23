<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        User::create([
            'name' => 'Nilmoni Mustafi',
            'email' => 'mustafi.amana@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
