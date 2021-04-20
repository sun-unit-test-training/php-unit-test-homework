<?php
namespace Modules\Exercise03\Tests\Http\Requests;

use Mockery;
use Tests\TestCase;
use Tests\TestValidation;
use Modules\Exercise03\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    use TestValidation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new CheckoutRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testTotalProducts()
    {
        $this->assertTrue($this->validateField('total_products.*', [
                1,
                2,
                3,
            ])
        );
    }
}
