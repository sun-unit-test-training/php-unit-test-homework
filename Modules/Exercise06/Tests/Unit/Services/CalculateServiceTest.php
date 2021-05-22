<?php

namespace Modules\Exercise04\Tests\Feature\Services;

use Modules\Exercise06\Services\CalculateService;
use Tests\TestCase;

class CalculateServiceTest extends TestCase
{
    protected $calculateService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->calculateService = app()->make(CalculateService::class);
    }

    /**
     * @param array $params
     *
     *  @param array $result
     *
     * @dataProvider providerCalculate
     */
    public function testCalculate($params, $result)
    {
        $response = $this->calculateService->calculate($params['bill'], $params['has_watch']);
        $this->assertEquals($result, $response);
    }

    public function providerCalculate()
    {
        return [
            [['bill'=> 5000, 'has_watch' => true], 300],
            [['bill'=> 5000, 'has_watch' => false], 120],
            [['bill'=> 2000, 'has_watch' => true], 240],
            [['bill'=> 2000, 'has_watch' => false], 60],
            [['bill'=> 50, 'has_watch' => false], 0],
            [['bill'=> 50, 'has_watch' => true], 180],
        ];
    }

    public function testCalculateException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculateService->calculate(-1, true);
    }
}
