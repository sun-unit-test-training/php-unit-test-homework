<?php

namespace Modules\Exercise02\Tests\Unit;

use Modules\Exercise02\Database\Factories\ATMFactory;
use Modules\Exercise02\Models\ATM;
use Tests\ModelTestCase;

class ATMTest extends ModelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new ATM(), [
            'fillable' => [
                'card_id',
                'is_vip'
            ],
            'casts' => [
                'is_vip' => 'boolean',
                'id' => 'int'
            ],
        ]);
    }

    public function test_new_factory()
    {
        $model = $this->Mock(ATM::class)->makePartial();
        $this->assertInstanceOf(ATMFactory::class, $model->newFactory());
    }
}
