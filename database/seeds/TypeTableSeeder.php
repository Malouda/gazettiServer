<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types=['Newspaper','Magazine'];

        foreach ($types as $type){

            DB::table('type')->insert([
                'type_name' => $type,
            ]);

        }
    }
}
