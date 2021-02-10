<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $publicationNames=['Uhuru','Nipashe','Jambo leo','Bongo.com','Mwanaspoti'];

        foreach ($publicationNames as $name){

            DB::table('publication')->insert([
                'publication_name' => $name,
                'publisher_id' => $faker->numberBetween(0, 6),
                'type_id' =>$faker->numberBetween(0, 3),
                'language_id' =>$faker->numberBetween(0,  3),
                'perspective_id'=>$faker->numberBetween( 0, 7),
                'daily'=>$faker->numberBetween( 0, 1),
                'weekly'=>$faker->numberBetween( 0, 1),
                'description'=>$faker->text(100),
                'maximum_headlines'=>1,
                'minimum_headlines'=>$faker->numberBetween(0, 10),
                'upload_deadline_accounts'=>$faker->numberBetween($min = 0, 6),
                'logo_url'=>$faker->url,
                'publication_email'=>$faker->email,
                'publication_delete'=>0,
                'release_date'=>$faker->dateTimeBetween($startDate = 'now', $endDate = '1 year', $timezone = date_default_timezone_get())
            ]);

        }
    }
}
