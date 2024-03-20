<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add data demo admin and user
        DB::table("users")->insert([
         [   'name' => 'Admin Thanh',
            'email' => 'thanhadmin@gmail.com',
            'password' => Hash::make('thanh0312'),
            'role' => 'admin',
            'status' => 'active',
        ],[
            'name' => 'User Thanh',
            'email' => 'thanhuser@gmail.com',
            'password' => Hash::make('thanh0312'),
            'role' => 'user',
            'status' => 'active',
        ]
        ]);
    }
}
