<?php

namespace Modules\Tests\Exercise05\Tests\Http\Request;

use Illuminate\Support\Facades\Validator;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderRequest();
    }

    /**
     * @dataProvider providerData
     */
    public function testRules($data, $testCase = 'NG')
    {
        $validator = Validator::make($data, $this->request->rules());

        if ($testCase === 'OK') {
            $this->assertTrue($validator->passes());
        } else {
            $this->assertTrue($validator->fails());
        }
    }

    public function providerData()
    {
        return [
            // Invalid data
            [$this->makeData()],
            // price: invalid
            [$this->makeData('String', 1, 1)],
            [$this->makeData('100,000', 1, 1)],
            // option_receive: invalid
            [$this->makeData(100, null, 1)],
            [$this->makeData(100, 0, 1)],
            [$this->makeData(100, 3, 1)],
            //option_coupon: invalid
            [$this->makeData(100, null, 0)],
            [$this->makeData(100, 1, 0)],
            [$this->makeData(100, 1, 3)],

            // Valid data
            [$this->makeData(100, 1, 1), 'OK'],
            [$this->makeData(100, 2, 1), 'OK'],
            [$this->makeData(100, 1, 1), 'OK'],
            [$this->makeData(100.000, 1, 2), 'OK'],
        ];
    }

    public function makeData($price = null, $optionReceive = null, $optionCoupon = null)
    {
        return [
            'price' => $price,
            'option_receive' => $optionReceive,
            'option_coupon' => $optionCoupon
        ];
    }
}
