<?php

use Illuminate\Database\Seeder;

class TelephonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Telephone::class, 32)->create();
    }
}
