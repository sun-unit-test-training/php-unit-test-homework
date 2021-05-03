<?php

namespace Modules\Exercise10\Tests;

use Illuminate\Support\Facades\Artisan;
use Modules\Exercise10\Contracts\Repositories\CardLevelRepository;
use Modules\Exercise10\Models\CardLevel;
use Modules\Exercise10\Repositories\CardLevelEloquent;
use Modules\Exercise10\Services\PrepaidCardService;
use Tests\TestCase;
use Mockery;

class PrepaidCardServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('module:seed Exercise10');
        $this->service = new PrepaidCardService(new CardLevelEloquent(new CardLevel()));
    }

    public function test__construct()
    {
        $repository = Mockery::mock(CardLevelRepository::class);
        $service = new PrepaidCardService($repository);
        $repositoryRef = $this->getHiddenProperty($service, 'repository');
        $this->assertSame($repository, $repositoryRef->getValue($service));
    }

    /**
     * @dataProvider input_for_prepaid_exception
     * @param $input
     */
    public function test_get_amount_return_exception($input)
    {
        $this->expectException(\ErrorException::class);
        $this->service->getAmountBonus($input);
    }

    public function input_for_prepaid_exception()
    {
        return [
            [
                [
                    'price' => 3000,
                    'ballot' => false,
                ]
            ],
            [
                [
                    'type' => 1,
                    'ballot' => false,
                ]
            ],
            [
                [
                    'type' => 1,
                    'price' => 22,
                ]
            ],
        ];
    }

    /**
     * @dataProvider input_for_prepaid
     * @param $input
     * @param $expected
     */
    public function test_get_amount_bonus($input, $expected)
    {
        $results = $this->service->getAmountBonus($input);
        $this->assertSame($expected, $results);
    }

    public function input_for_prepaid()
    {
        return [
            [
                [
                    'type' => 1,
                    'price' => 3000,
                    'ballot' => false,
                ],
                [
                    'type' => 1,
                    'price' => 3000,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 3000,
                ]
            ],
            [
                [
                    'type' => 2,
                    'price' => 3000,
                    'ballot' => false,
                ],
                [
                    'type' => 2,
                    'price' => 3000,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 3000,
                ]
            ],
            [
                [
                    'type' => 3,
                    'price' => 3000,
                    'ballot' => false,
                ],
                [
                    'type' => 3,
                    'price' => 3000,
                    'ballot' => false,
                    'bonus' => 0,
                    'amount' => 3000,
                ]
            ],
            [
                [
                    'type' => 1,
                    'price' => 22,
                    'ballot' => true,
                ],
                [
                    'type' => 1,
                    'price' => 22,
                    'ballot' => true,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => true,
                ],
                [
                    'type' => 2,
                    'price' => 22,
                    'ballot' => true,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 3,
                    'price' => 22,
                    'ballot' => true,
                ],
                [
                    'type' => 3,
                    'price' => 22,
                    'ballot' => true,
                    'bonus' => 0,
                    'amount' => 22,
                ]
            ],
            [
                [
                    'type' => 1,
                    'price' => 10000,
                    'ballot' => true,
                ],
                [
                    'type' => 1,
                    'price' => 10000,
                    'ballot' => true,
                    'bonus' => 400,
                    'amount' => 9600,
                ]
            ],
            [
                [
                    'type' => 2,
                    'price' => 5000,
                    'ballot' => true,
                ],
                [
                    'type' => 2,
                    'price' => 5000,
                    'ballot' => true,
                    'bonus' => 250,
                    'amount' => 4750,
                ]
            ],
            [
                [
                    'type' => 3,
                    'price' => 3000,
                    'ballot' => true,
                ],
                [
                    'type' => 3,
                    'price' => 3000,
                    'ballot' => true,
                    'bonus' => 150,
                    'amount' => 2850,
                ]
            ],
        ];
    }
}
