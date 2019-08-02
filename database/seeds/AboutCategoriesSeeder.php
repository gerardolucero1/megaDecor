<?php

use App\AboutCategory;
use Illuminate\Database\Seeder;

class AboutCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AboutCategory::class, 5)->create(); 
    }
}
