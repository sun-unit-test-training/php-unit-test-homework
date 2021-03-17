<?php

namespace Modules\Exercise01\Tests\Feature\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise01\Http\Requests\OrderRequest;
use Modules\Exercise01\Models\Voucher;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    protected $orderRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRequest = new OrderRequest();
    }

    public function test_validate_without_voucher()
    {
        $input = [
            'quantity' => 10
        ];

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_validate_with_voucher_active()
    {
        $input = [
            'quantity' => 10,
            'voucher' => 'voucher_code'
        ];

        DB::table('vouchers')->truncate();

        Voucher::factory()->create([
            'code' => 'voucher_code',
            'is_active' => true
        ]);

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public function test_validate_with_voucher_not_active()
    {
        $input = [
            'quantity' => 10,
            'voucher' => 'voucher_code'
        ];

        DB::table('vouchers')->truncate();

        Voucher::factory()->create([
            'code' => 'voucher_code',
            'is_active' => false
        ]);

        $validator = Validator::make($input, $this->orderRequest->rules());
        $this->assertTrue($validator->fails());
    }
}
