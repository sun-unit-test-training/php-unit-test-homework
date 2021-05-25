<?php

namespace Modules\Exercise03\Tests;

use Tests\TestCase;
use Tests\SetupDatabaseTrait;
use Modules\Exercise03\Models\Product;

class ProductModelTest extends TestCase
{
    use SetupDatabaseTrait;

    public function testProductModel()
    {
        $inputs = [
            'name' => 'nhitt test',
            'type' => Product::CRAVAT_TYPE,
        ];

        $product = (new Product())->fill($inputs);

        $this->assertEquals(Product::CRAVAT_TYPE, $product->type);
    }
}
