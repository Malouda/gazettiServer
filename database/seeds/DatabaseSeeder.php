<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //$this->call(PublisherTableSeeder::class);

        $this->call(GrouptableSeeder::class);

        //$this->call(PublicationSeeder::class);

        $this->call(TypeTableSeeder::class);

        $this->call(LanguageTableSeeder::class);

        $this->call(PerspectiveTableSeeder::class);

        $this->call(LocationTableSeeder::class);

        $this->call(UserTableSeeder::class);

        $this->call(GenderTableSeeder::class);

        $this->call(GroupUserSeeder::class);

    }
}
