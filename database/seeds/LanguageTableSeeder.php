<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages=['Swahili','English'];

        foreach ($languages as $language){

            DB::table('language')->insert([
                'language_name' => $language,
            ]);

        }
    }
}
