<?php

namespace Modules\Exercise05\Tests\Feature;

use Tests\TestCase;

/**
 * Class Exercise05ControllerTest
 */
class Exercise05ControllerTest extends TestCase
{
    /**
     * Get listing of the resource
     *
     * @test
     *
     * @return void
     */
    public function get_listing_of_resource_success()
    {
        $response = $this->get('/exercise05');
        $data = $response->getOriginalContent()->getData();

        $this->assertArrayHasKey('optionReceives', $data);
        $this->assertArrayHasKey('optionCoupons', $data);
    }

    /**
     * Store a new resource success
     *
     * @test
     *
     * @return void
     */
    public function store_new_resource_success()
    {
        $response = $this->post('/exercise05', [
            'price' => 100,
            'option_receive' => config('exercise05.receive_at_store'),
            'option_coupon' => config('exercise05.no_coupon'),
        ]);
        $data = $response->getOriginalContent()->getData();

        $this->assertArrayHasKey('resultOrder', $data);
        $this->assertArrayHasKey('detailOrder', $data);
    }

    /**
     * Store a new resource invalid
     *
     * @test
     *
     * @dataProvider providerStoreResourceInvalid
     *
     * @return void
     */
    public function store_new_resource_invalid($invalidInput)
    {
        $this->post('/exercise05', $invalidInput)
            ->assertSessionHasErrors('price')
            ->assertSessionHasErrors('option_receive')
            ->assertSessionHasErrors('option_coupon');
    }

    /**
     * Provider for store resource invalid
     *
     * @return array
     */
    public function providerStoreResourceInvalid()
    {
        return [
            [
                [],
            ],
            [
                [
                    'price' => 'invalid',
                    'option_receive' => 'invalid',
                    'option_coupon' => 'invalid',
                ]
            ]
        ];
    }
}
