<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(isNull(User::where('email', 'mustafi.amana@gmail.com')->first())){
            $user = new User();
            $user->name = "Nilmoni Mustafi";
            $user->email = "mustafi.amana@gmail.com";
            $user->password = Hash::make('12345678');
            $user->save();
        }
    }
}
