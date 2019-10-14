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
        $this->call(UsersTableSeeder::class);
        $this->call(AboutCategoriesSeeder::class);
        $this->call(MoralCategoriesSeeder::class);
        $this->call(InventoriesSeeder::class);
        //$this->call(ClientsSeeder::class);
        //$this->call(PhysicalPersonsSeeder::class);
        //$this->call(MoralPersonsSeeder::class);
        //$this->call(TelephonesSeeder::class);
        //$this->call(PermissionsTableSeeder::class);
        
    }
}
