<?php

use Illuminate\Database\Seeder;

class MissingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MissingProducts::class, 30)->create();
    }
}
