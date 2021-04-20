<?php
namespace App\Modules\Exercise06\Tests\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise06\Services\CalculateService;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class CalculateServiceTest extends TestCase
{
    public function testCalculateException()
    {
        $this->expectException(InvalidArgumentException::class);
        $service = new CalculateService;
        $service->calculate(0);
    }

    /**
     * @dataProvider providerTestCalculatePass
     */
    public function testCalculatePass($input, $expect)
    {
        $service = new CalculateService;
        $response = $service->calculate($input, true);

        $this->assertEquals($response, $expect);
    }

    public function providerTestCalculatePass()
    {
        return [
            [
                120,
                180,
            ],
            [
                2200,
                240,
            ],
            [
                5100,
                300,
            ],
        ];
    }
}
