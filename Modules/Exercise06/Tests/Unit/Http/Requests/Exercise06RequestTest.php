<?php

namespace Modules\Exercise06\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise06\Http\Requests\Exercise06Request;

class Exercise06RequestTest extends TestCase
{
    protected $exercise06Request;

    public function setUp(): void
    {
        parent::setUp();
        $this->exercise06Request = new Exercise06Request();
    }

    /**
     * Test rules function
     *
     * @return void
     */
    public function test_rules()
    {
        $this->assertEquals([
            'bill' => 'required|integer|min:0',
            'has_watch' => 'nullable|boolean',
        ], $this->exercise06Request->rules());
    }

    /**
     * Test validate bill with case fail required
     *
     * @return void
     */
    public function test_validate_bill_with_fail_required()
    {
        $data = [
            'bill' => null,
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertFalse($validator->passes());
    }

    /**
     * Test validate bill with case fail integer
     *
     * @return void
     */
    public function test_validate_bill_with_fail_integer()
    {
        $data = [
            'bill' => 'Ahihi',
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertFalse($validator->passes());
    }

    /**
     * Test validate bill with case fail min
     *
     * @return void
     */
    public function test_validate_bill_with_fail_min()
    {
        $data = [
            'bill' => -10,
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertFalse($validator->passes());
    }

    /**
     * Test validate bill with case pass
     *
     * @return void
     */
    public function test_validate_bill_pass()
    {
        $data = [
            'bill' => 10,
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * Test validate has_watch with case fail boolean
     *
     * @return void
     */
    public function test_validate_has_watch_with_fail_boolean()
    {
        $data = [
            'bill' => 10,
            'has_watch' => 'Ahihi',
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertFalse($validator->passes());
    }

    /**
     * Test validate has_watch with case pass
     *
     * @return void
     */
    public function test_validate_has_watch_pass()
    {
        $data = [
            'bill' => 10,
            'has_watch' => true,
        ];

        $validator = Validator::make($data, $this->exercise06Request->rules());
        $this->assertTrue($validator->passes());
    }
}
