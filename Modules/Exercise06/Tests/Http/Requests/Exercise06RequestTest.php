<?php
namespace Modules\Exercise06\Tests\Http\Requests;

use Mockery;
use Tests\TestCase;
use Tests\TestValidation;
use Modules\Exercise06\Http\Requests\Exercise06Request;

class Exercise06RequestTest extends TestCase
{
    use TestValidation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules     = (new Exercise06Request())->rules();
        $this->validator = $this->app['validator'];
    }

    public function testBill()
    {
        $this->assertTrue($this->validateField('bill', 200));
    }

    public function testHasWatch()
    {
        $this->assertTrue($this->validateField('has_watch', true));
    }
}
