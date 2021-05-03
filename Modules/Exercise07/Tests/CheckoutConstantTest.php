<?php

namespace Modules\Exercise07\Tests;

use Modules\Exercise07\Constants\Checkout;
use Tests\TestCase;

class CheckoutConstantTest extends TestCase
{
    public function test_checkout_const()
    {
        $this->assertEquals(500, Checkout::SHIPPING_FEE);
        $this->assertEquals(500, Checkout::SHIPPING_EXPRESS_FEE);
        $this->assertEquals(5000, Checkout::FREE_SHIPPING_AMOUNT);
    }
}
