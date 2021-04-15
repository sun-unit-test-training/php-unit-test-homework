<?php
namespace Modules\Exercise03\Tests\Models;

use Tests\TestCase;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Database\Factories\ProductFactory;

class ProductTest extends TestCase
{
    public function testNewFactory()
    {
        $product = Product::newFactory();

        $this->assertInstanceOf(ProductFactory::class, $product);
    }
}
