<?php

namespace Modules\Exercise03\Tests\Unit\Repositories;

use DB;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    public function test_all_function()
    {
        // Prepare database
        DB::table('exercise03_products')->truncate();
        Product::factory()->cravat()->create([
            'name' => 'Cà vạt',
            'thumbnail' => 'images/exercise03/cravat.jpg',
        ]);

        // Testing `all` function
        $product = new Product();
        $productRepository = new ProductRepository($product);

        $products = $productRepository->all();

        $this->assertEquals(1, $products->count());
    }
}
