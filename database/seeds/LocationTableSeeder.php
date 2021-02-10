<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations=['Morogoro','Dar es Salaam','Mbeya','Mwanza','Iringa','Pwani','Arusha'];

        foreach ($locations as $location){

            DB::table('location')->insert([
                'location_name' => $location,
            ]);

        }
    }
}
