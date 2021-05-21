<?php

namespace Modules\Exercise03\Tests\Unit\Models;

use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_fields()
    {
        $inputs = [
            'name' => 'product',
            'type' => Product::OTHER_TYPE,
        ];
        $atmModel = new Product();
        $atmModel->fill($inputs);
        $this->assertEquals($inputs['name'], $atmModel->name);
        $this->assertEquals($inputs['type'], $atmModel->type);
    }

    public function test_product_new_factory()
    {
        $product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $product);
    }
}