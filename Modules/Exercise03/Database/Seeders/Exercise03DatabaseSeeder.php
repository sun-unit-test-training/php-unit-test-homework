<?php

namespace Modules\Exercise03\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Exercise03\Models\Product;

class Exercise03DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->cravat()->create([
            'name' => 'Cà vạt',
            'thumbnail' => 'images/exercise03/cravat.jpg',
        ]);
        Product::factory()->whiteShirt()->create([
            'name' => 'Sơ mi trắng',
            'thumbnail' => 'images/exercise03/white_shirt.jpg',
        ]);
        Product::factory()->other()->create([
            'name' => 'Loại khác',
            'thumbnail' => 'images/exercise03/default.jpg',
        ]);
    }
}
