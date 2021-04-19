<?php
namespace Modules\Exercise05\Tests\Http\Requests;

use Mockery;
use Tests\TestCase;
use Tests\TestValidation;
use Modules\Exercise05\Http\Requests\OrderRequest;

class OrderRequestTest extends TestCase
{
    use TestValidation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new OrderRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testPrice()
    {
        $this->assertTrue($this->validateField('price', 1200));
    }

    public function testOptionReceive()
    {
        $this->assertTrue($this->validateField('option_receive', '1'));
    }

    public function testOptionCoupoin()
    {
        $this->assertTrue($this->validateField('option_coupon', '1'));
    }
}
