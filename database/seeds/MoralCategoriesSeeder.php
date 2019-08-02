<?php

use App\MoralCategory;
use Illuminate\Database\Seeder;

class MoralCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MoralCategory::class, 6)->create();
    }
}
