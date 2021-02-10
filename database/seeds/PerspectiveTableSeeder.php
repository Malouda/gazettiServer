<?php

use Illuminate\Database\Seeder;

class PerspectiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perspectives=['Politics','Religion','Lifestyle','Sports','Special Interest'];

        foreach ($perspectives as $perspective){

            DB::table('perspective')->insert([
                'perspective_name' => $perspective,
            ]);

        }
    }
}
