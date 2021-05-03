<?php

namespace Modules\Exercise10\Tests;

use Modules\Exercise10\Models\CardLevel;
use Tests\TestCase;

class CardLevelTest extends TestCase
{
    public function test_properties()
    {
        $model = new CardLevel();
        $fillableRef = $this->getHiddenProperty($model, 'fillable');
        $this->assertSame([
            'type',
            'amount_limit',
            'bonus',
        ], $fillableRef->getValue($model));
    }
}
