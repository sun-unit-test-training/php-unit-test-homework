<?php
namespace App\Modules\Exercise07\Tests\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise07\Services\CheckoutService;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class CheckoutServiceTest extends TestCase
{
    /**
     * @dataProvider providerTestCalculateShippingFee
     */
    public function testCalculateShippingFee($input, $expect)
    {
        $service = new CheckoutService;
        $response = $service->calculateShippingFee($input);

        $this->assertEquals($response['amount'], $expect['amount']);
        $this->assertEquals($response['shipping_fee'], $expect['shipping_fee']);
    }

    public function providerTestCalculateShippingFee()
    {
        return [
            [
                [
                    'amount' => 5001,
                ],
                [
                    'amount' => 5001,
                    'shipping_fee' => 0,
                ]
            ],
            [
                [
                    'amount' => 500,
                ],
                [
                    'amount' => 500,
                    'shipping_fee' => 500,
                ]
            ],
        ];
    }
}
