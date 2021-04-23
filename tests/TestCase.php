<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use SetupDatabaseTrait;

    protected function getHiddenProperty($object, $property)
    {
        $class = new \ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }
}
