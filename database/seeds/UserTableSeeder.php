<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fname' => 'Admin',
            'lname'=>'Admin',
            'username'=>'admin',
            'password'=>Hash::make('1234'),
            'user_group_id'=>1,
            'location_id'=>1,
            'publisher_id'=>1,
            'phone'=>'0654523665',
            'email'=>'deomwilanga@gmail.com',
            'age'=>30,
            'gender_id'=>1,
            'profile_picture_url'=>'dcfdsfdds',
        ]);
    }
}
