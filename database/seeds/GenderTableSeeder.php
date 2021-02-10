<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $gender=['Male','Female'];

        foreach ($gender as $name){

            DB::table('gender')->insert([
                'gender_name' => $name,
            ]);

        }
    }
}
