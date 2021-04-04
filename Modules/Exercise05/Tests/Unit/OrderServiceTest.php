<?php

namespace Modules\Exercise05\Tests\Unit;

use Tests\TestCase;
use Modules\Exercise05\Services\OrderService;

/**
 * Class OrderServiceTest
 */
class OrderServiceTest extends TestCase
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderService();
    }

    /**
     * Handle discount when low price and receive at store
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_low_price_and_receive_at_store()
    {
        $price = 100;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ]);

        $this->assertEquals([
            'price' => $price,
            'discount_pizza' => config('exercise05.discount_pizza'),
            'discount_potato' => null,
        ], $response);
    }

    /**
     * Handle discount when high price and receive at store
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_high_price_and_receive_at_store()
    {
        $price = 2000;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ]);

        $this->assertEquals([
            'price' => $price,
            'discount_pizza' => config('exercise05.discount_pizza'),
            'discount_potato' => config('exercise05.free_potato'),
        ], $response);
    }

    /**
     * Handle discount when low price and receive at home and no coupon
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_low_price_and_receive_at_home_and_no_coupon()
    {
        $price = 100;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_home'),
            'option_coupon' => config('exercise05.no_coupon'),
        ]);

        $this->assertEquals([
            'price' => $price,
            'discount_pizza' => null,
            'discount_potato' => null,
        ], $response);
    }

    /**
     * Handle discount when low price and receive at home and has coupon
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_low_price_and_receive_at_home_and_has_coupon()
    {
        $price = 100;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_home'),
            'option_coupon' => config('exercise05.has_coupon'),
        ]);

        $newPrice = round(($price * 80) / 100, 2);

        $this->assertEquals([
            'price' => $newPrice,
            'discount_pizza' => null,
            'discount_potato' => null,
        ], $response);
    }

    /**
     * Handle discount when high price and receive at home and no coupon
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_high_price_and_receive_at_home_and_no_coupon()
    {
        $price = 2000;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_home'),
            'option_coupon' => config('exercise05.no_coupon'),
        ]);

        $this->assertEquals([
            'price' => $price,
            'discount_pizza' => null,
            'discount_potato' => config('exercise05.free_potato'),
        ], $response);
    }

    /**
     * Handle discount when high price and receive at home and has coupon
     *
     * @test
     *
     * @return void
     */
    public function handle_discount_when_high_price_and_receive_at_home_and_has_coupon()
    {
        $price = 2000;
        $response = $this->orderService->handleDiscount([
            'price' => $price,
            'option_receive' => config('exercise05.receive_at_home'),
            'option_coupon' => config('exercise05.has_coupon'),
        ]);

        $newPrice = round(($price * 80) / 100, 2);

        $this->assertEquals([
            'price' => $newPrice,
            'discount_pizza' => null,
            'discount_potato' => config('exercise05.free_potato'),
        ], $response);
    }
}
