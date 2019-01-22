<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       if( $this->call(AdminUsersTableSeeder::class))
       $this->command->info('Table Admin Users seeded!');
       
       if( $this->call(AllCountriesTableSeeder::class))
       $this->command->info('Table All Countries seeded!');
       
        if( $this->call(AllLanguagesTableSeeder::class))
        $this->command->info('Table All Languages seeded!');
    }
}
