<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Clear the categories table
          Category::truncate();

          // Insert sample data
          $electronics = Category::create(['name' => 'Electronics']);
          $mobiles = Category::create(['name' => 'Mobile Phones', 'parent_id' => $electronics->id]);
          Category::create(['name' => 'Smartphones', 'parent_id' => $mobiles->id]);
          Category::create(['name' => 'Feature Phones', 'parent_id' => $mobiles->id]);
          Category::create(['name' => 'Laptops', 'parent_id' => $electronics->id]);
  
          $fashion = Category::create(['name' => 'Fashion']);
          $men = Category::create(['name' => 'Men', 'parent_id' => $fashion->id]);
          Category::create(['name' => 'Shirts', 'parent_id' => $men->id]);
          Category::create(['name' => 'Trousers', 'parent_id' => $men->id]);
          $women = Category::create(['name' => 'Women', 'parent_id' => $fashion->id]);
          Category::create(['name' => 'Dresses', 'parent_id' => $women->id]);
          Category::create(['name' => 'Shoes', 'parent_id' => $women->id]);
    }
}
