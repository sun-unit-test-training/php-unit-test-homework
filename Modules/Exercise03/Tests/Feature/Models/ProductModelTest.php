<?php

namespace Modules\Exercise03\Tests\Feature\Models;

use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use SetupDatabaseTrait;

    public function test_product_new_factory()
    {
        $product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $product);
    }
}
