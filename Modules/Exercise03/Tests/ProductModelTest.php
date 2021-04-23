<?php

namespace Tests\Feature;

use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_new_factory()
    {
        $product = Product::newFactory();

        $cravat = $product->cravat()->make();
        $this->assertEquals(Product::CRAVAT_TYPE, $cravat->type);

        $whiteShirt = $product->whiteShirt()->make();
        $this->assertEquals(Product::WHITE_SHIRT_TYPE, $whiteShirt->type);

        $other = $product->other()->make();
        $this->assertEquals(Product::OTHER_TYPE, $other->type);

        $this->assertNotNull($product->definition()['name']);
        $this->assertNotNull($product->definition()['thumbnail']);
    }
}
