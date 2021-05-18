<?php

namespace Modules\Exercise05\Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderService = new OrderService();
    }

    public function test_handle_discount_no_discount()
    {
        $param = [
            'price' => config('exercise05.price_has_discount_potato') - 1,
            'option_receive' => config('exercise05.receive_at_store'),
        ];

        $infoBill = $this->orderService->handleDiscount($param);

        $this->assertEquals($param['price'], $infoBill['price']);
        $this->assertEquals(config('exercise05.discount_pizza'), $infoBill['discount_pizza']);
        $this->assertNull($infoBill['discount_potato']);
    }

    public function test_handle_discount_discount_potato_receive_home_has_coupon()
    {
        $expectedPrice = config('exercise05.price_has_discount_potato') + 1;
        $param = [
            'price' => $expectedPrice,
            'option_receive' => config('exercise05.receive_at_home'),
            'option_coupon' => config('exercise05.has_coupon'),
        ];

        $infoBill = $this->orderService->handleDiscount($param);

        $this->assertEquals(round(($expectedPrice * 80) / 100, 2), $infoBill['price']);
        $this->assertEquals(config('exercise05.free_potato'), $infoBill['discount_potato']);
        $this->assertNull($infoBill['discount_pizza']);
    }
}
