<?php

namespace Modules\Exercise10\Tests;

use Illuminate\Support\Facades\Artisan;
use Modules\Exercise10\Models\CardLevel;
use Modules\Exercise10\Repositories\CardLevelEloquent;
use Tests\TestCase;
use Mockery;

class CardLevelEloquentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('module:seed Exercise10');
    }

    public function test_construct()
    {
        $model = Mockery::mock(CardLevel::class);
        $repository = new CardLevelEloquent($model);
        $eloquentRef = $this->getHiddenProperty($repository, 'model');
        $this->assertSame($model, $eloquentRef->getValue($repository));
    }

    public function test_find_bonus()
    {
        $model = new CardLevel();
        $repository = new CardLevelEloquent($model);
        $bonus = $repository->findBonus(1, 6000);
        $this->assertInstanceOf(CardLevel::class, $bonus);
        $this->assertEquals(2, $bonus->id);
    }
}
