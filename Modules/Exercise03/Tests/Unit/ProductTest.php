<?php

namespace Modules\Exercise02\Tests\Unit;

use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Tests\ModelTestCase;

class ProductTest extends ModelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Product(), [
            'fillable' => [
                'name', 'type'
            ],
        ]);
    }

    public function test_new_factory()
    {
        $model = $this->Mock(Product::class)->makePartial();
        $this->assertInstanceOf(ProductFactory::class, $model->newFactory());
    }
}
