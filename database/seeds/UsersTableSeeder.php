<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Arifur Rahman',
            'email'=>'iarif4u@gmail.com',
            'password'=> Hash::make('123456'),
        ]);
    }
}
