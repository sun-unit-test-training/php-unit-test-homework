<?php
namespace Modules\Exercise07\Tests\Http\Requests;

use Mockery;
use Tests\TestCase;
use Tests\TestValidation;
use Modules\Exercise07\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    use TestValidation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new CheckoutRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testAmount()
    {
        $this->assertTrue($this->validateField('amount', 200));
    }
}
