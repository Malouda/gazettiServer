<?php

use Illuminate\Database\Seeder;

class GrouptableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publisherNames=['SuperAdmin','SystemAdmin','Employee','SubEmployee','Agent','Vendors','Reader'];

        foreach ($publisherNames as $name){

            DB::table('user_groups')->insert([
                'user_group_name' => $name,
            ]);

        }
    }
}
