<?php

namespace Modules\Tests\Exercise03\Tests\Feature\Model;

use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNewFactory()
    {
        $product = Product::factory()->make();
        $this->assertInstanceOf(Product::class, $product);
    }
}
