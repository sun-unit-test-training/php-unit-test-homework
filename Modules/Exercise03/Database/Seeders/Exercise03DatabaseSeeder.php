<?php

namespace Modules\Exercise03\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Exercise03\Entities\Product;

class Exercise03DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class)->state('cravat')->create([
            'name' => 'Cà vạt',
            'thumbnail' => 'images/exercise03/cravat.jpg',
        ]);
        factory(Product::class)->state('white_shirt')->create([
            'name' => 'Sơ mi trắng',
            'thumbnail' => 'images/exercise03/white_shirt.jpg',
        ]);
        factory(Product::class)->state('other')->create([
            'name' => 'Loại khác',
            'thumbnail' => 'images/exercise03/default.jpg',
        ]);
    }
}
