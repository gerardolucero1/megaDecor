<?php

use App\Faltantes;
use Illuminate\Database\Seeder;

class FaltanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Faltantes::class, 30)->create();
    }
}
