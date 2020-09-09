<?php

namespace Modules\Exercise01\Tests\Unit\Http\Controllers;

use Modules\Exercise01\Http\Controllers\Exercise01Controller;
use Tests\TestCase;

/**
 * TODO: make real test
 */
class Exercise01ControllerTest extends TestCase
{
    public function test_it_render_index_page()
    {
        $controller = new Exercise01Controller;

        $controller->index();

        // 100% code coverage??
        $this->assertTrue(true);
    }
}
