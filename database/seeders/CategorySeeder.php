<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'standard',
            'description' => 'paket standard'
        ]);

        Category::create([
            'name' => 'lifestyle',
            'description' => 'paket lifestyle'
        ]);

        Category::create([
            'name' => 'advance',
            'description' => 'paket advance'
        ]);
    }
}
