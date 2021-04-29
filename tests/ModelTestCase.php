<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class ModelTestCase extends TestCase
{
    protected function runConfigurationAssertions(Model $model, $assertions)
    {

        $assertions = array_merge([
            'fillable' => [],
            'hidden' => [],
            'guarded' => ['*'],
            'visible' => [],
            'casts' => ['id' => 'int'],
            'dates' => ['created_at', 'updated_at'],
            'collectionClass' => Collection::class,
            'table' => null,
            'primaryKey' => 'id',
            'connection' => null,
        ], $assertions);
        extract($assertions);
        $this->assertEquals($assertions['fillable'], $model->getFillable());
        $this->assertEquals($assertions['guarded'], $model->getGuarded());
        $this->assertEquals($assertions['hidden'], $model->getHidden());
        $this->assertEquals($assertions['visible'], $model->getVisible());
        $this->assertEquals($assertions['casts'], $model->getCasts());
        $this->assertEquals($assertions['dates'], $model->getDates());
        $this->assertEquals($assertions['primaryKey'], $model->getKeyName());
        $c = $model->newCollection();
        $this->assertEquals($assertions['collectionClass'], get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
        if ($assertions['connection'] !== null) {
            $this->assertEquals($assertions['connection'], $model->getConnectionName());
        }
        if ($assertions['table'] !== null) {
            $this->assertEquals($assertions['table'], $model->getTable());
        }
    }
}