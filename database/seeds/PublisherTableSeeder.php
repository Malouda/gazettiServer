<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PublisherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $publisherNames=['Guardian','Nipashe','Mwananchi','Mtanzania','Mwanaspoti'];

        foreach ($publisherNames as $name){

            DB::table('publisher')->insert([
                'publisher_name' => $name,
                'location_id' =>$faker->unique()->randomDigit,
                'email' =>str_random(10).'@gmail.com',
                'publisher_phone'=>$faker->e164PhoneNumber,
                'maximum_employees'=>$faker->unique()->randomDigit,
                'account_expiry'=>$faker->dateTime,
                'status'=>1,
                'logo_url'=>$faker->url,
                'publisher_delete'=>0
            ]);

        }
    }
}
