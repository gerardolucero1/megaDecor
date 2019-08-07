<?php

use App\MoralPerson;
use Illuminate\Database\Seeder;

class MoralPersonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MoralPerson::class, 7)->create();
    }
}
