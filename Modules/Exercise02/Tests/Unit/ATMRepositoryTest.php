<?php

namespace Modules\Exercise02\Tests\Unit;

use Mockery;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Repositories\ATMRepository;
use PHPUnit\Framework\TestCase;

class ATMRepositoryTest extends TestCase
{
    protected $atmRepository;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = Mockery::mock(ATM::class);
        $this->atmRepository = new ATMRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('where->first')->andReturn([]);

        $result = $this->atmRepository->find(1);
        $this->assertEquals([], $result);
    }
}
