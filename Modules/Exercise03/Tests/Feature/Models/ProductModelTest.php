<?php

namespace Modules\Exercise03\Tests\Feature\Models;

use Modules\Exercise03\Models\Product;
use Tests\SetupDatabaseTrait;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use SetupDatabaseTrait;

    /**
     * This test does not count coverage for model Product,
     * because we are test for class property `fillable`, not method
     *
     * But it is added to ensure we initialize property correctly
     */
    public function test_fields_are_fillable()
    {
        $inputs = [
            'name' => 'Huong',
            'type' => 1,
        ];

        $product = Product::create($inputs);

        $this->assertEquals($inputs['name'], $product->name);
        $this->assertEquals($inputs['type'], $product->type);
    }
}
