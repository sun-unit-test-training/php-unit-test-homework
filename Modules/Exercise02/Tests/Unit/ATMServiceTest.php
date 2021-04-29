<?php

namespace Modules\Exercise02\Tests\Unit;

use Carbon\Carbon;
use Mockery;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Mockery\Mock;
use Modules\Exercise02\Models\ATM;

class ATMServiceTest extends TestCase
{
    protected $atmService;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(ATMRepository::class);
        $this->atmService = new ATMService($this->repository);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_find_fail()
    {
        $this->repository->shouldReceive('find')->andReturn(null);
        $this->expectException(InvalidArgumentException::class);
        $this->atmService->calculate(1);
    }

    public function test_card_is_vip()
    {
        $this->model = Mockery::mock(ATM::class)->makePartial();
        $this->model->is_vip = true;
        $this->repository->shouldReceive('find')->andReturn($this->model);
        $result =  $this->atmService->calculate(1);

        $this->assertEquals(0, $result);
    }

    public function test_card_in_holiday()
    {
        $this->model =  Mockery::mock(ATM::class)->makePartial();
        $this->model->is_vip = false;
        Carbon::setTestNow(Carbon::parse('2021-01-01'));
        $this->repository->shouldReceive('find')->andReturn($this->model);
        $result =  $this->atmService->calculate(1);

        $this->assertEquals(110, $result);
    }

    public function test_card_in_weekend()
    {
        $this->model = Mockery::mock(ATM::class)->makePartial();
        $this->model->is_vip = false;
        Carbon::setTestNow(Carbon::parse('2021-04-15'));
        $this->repository->shouldReceive('find')->andReturn($this->model);
        $result =  $this->atmService->calculate(1);

        $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h44()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:44:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h45()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:45:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_8h46()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:46:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h58()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:58:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h59()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:59:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_18h00()
    {
        $atm =  Mockery::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 18:00:00'));
        $this->repository->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }
}
