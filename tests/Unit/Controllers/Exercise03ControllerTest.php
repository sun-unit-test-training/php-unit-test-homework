<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use \App\Http\Controllers;

class Exercise03ControllerTest extends TestCase
{
    protected $exercise03Controller;
    /**
     * @throws \Exception
     */

    public function setUp():void
    {
        parent::setUp();

        $this->exercise03Controller = new Controllers\Exercise03Controller();
    }

    // functions test with rule in decision table

    public function test_calculate_discount_with_rule_1()
    {
        $products = [
            [
                'id' => 1,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 2,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 3,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 4,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 5,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 6,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 7,
                'type' => 1,
                'name' => 'cravat'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(12, $result);
    }

    public function test_calculate_discount_with_rule_2()
    {
        $products = [
            [
                'id' => 1,
                'type' => 3,
                'name' => 'product1'
            ],
            [
                'id' => 2,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 3,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 4,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 5,
                'type' => 3,
                'name' => 'product2'
            ],
            [
                'id' => 6,
                'type' => 3,
                'name' => 'product3'
            ],
            [
                'id' => 7,
                'type' => 3,
                'name' => 'product4'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_calculate_discount_with_rule_3()
    {
        $products = [
            [
                'id' => 1,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 2,
                'type' => 3,
                'name' => 'product1'
            ],
            [
                'id' => 3,
                'type' => 3,
                'name' => 'product6'
            ],
            [
                'id' => 4,
                'type' => 3,
                'name' => 'product5'
            ],
            [
                'id' => 5,
                'type' => 3,
                'name' => 'product4'
            ],
            [
                'id' => 6,
                'type' => 3,
                'name' => 'product2'
            ],
            [
                'id' => 7,
                'type' => 3,
                'name' => 'product3'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_calculate_discount_with_rule_5()
    {
        $products = [
            [
                'id' => 1,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 2,
                'type' => 2,
                'name' => 'white shirt'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(5, $result);
    }

    public function test_calculate_discount_with_rule_6()
    {
        $products = [
            [
                'id' => 1,
                'type' => 2,
                'name' => 'white shirt'
            ],
            [
                'id' => 2,
                'type' => 3,
                'name' => 'product1'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }

    public function test_calculate_discount_with_rule_7()
    {
        $products = [
            [
                'id' => 1,
                'type' => 1,
                'name' => 'cravat'
            ],
            [
                'id' => 2,
                'type' => 3,
                'name' => 'product1'
            ],
        ];

        $result = $this->exercise03Controller->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }
}