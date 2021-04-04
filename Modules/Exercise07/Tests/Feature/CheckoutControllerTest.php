<?php

namespace Modules\Exercise07\Tests\Feature;

use Tests\TestCase;

/**
 * Class CheckoutControllerTest
 */
class CheckoutControllerTest extends TestCase
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
        $response = $this->get('/exercise07');
        $response->assertViewIs('exercise07::checkout.index');
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
        $response = $this->post('/exercise07', [
            'amount' => 100,
        ]);

        $response->assertRedirect('/');
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
        $this->post('/exercise07', $invalidInput)
            ->assertSessionHasErrors('amount');
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
                    'amount' => 'invalid',
                ]
            ],
            [
                [
                    'amount' => 0,
                ]
            ]
        ];
    }
}
