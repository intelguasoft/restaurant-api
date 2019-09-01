<?php

use Illuminate\Database\Seeder;
use IntelGUA\FoodPoint\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 50)->create();
    }
}
