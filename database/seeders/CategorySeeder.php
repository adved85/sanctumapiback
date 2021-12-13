<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categoriesJson = File::get("database/seeders/data/categories_mock.json");
        $categoriesArray = json_decode($categoriesJson, true);

        foreach ($categoriesArray as $item) {
            Category::create($item);
        }
    }
}
