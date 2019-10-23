<?php
use App\MissingProducts;
use Illuminate\Database\Seeder;
class MissingProductsSeeder extends Seeder
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