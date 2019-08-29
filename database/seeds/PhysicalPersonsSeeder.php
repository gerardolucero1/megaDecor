<?php

use App\PhysicalPerson;
use Illuminate\Database\Seeder;

class PhysicalPersonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PhysicalPerson::class, 9)->create();
    }
}
