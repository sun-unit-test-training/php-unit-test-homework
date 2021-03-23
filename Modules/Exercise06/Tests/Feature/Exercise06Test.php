<?php

namespace Modules\Exercise06\Tests\Feature;

use Tests\TestCase;

class Exercise06Test extends TestCase
{
    public function test_view_render()
    {
        $this->get('/exercise06')
             ->assertStatus(200)
             ->assertViewIs('exercise06::index')
             ->assertViewHasAll([
                 'case1',
                 'case2',
                 'freeTimeForMovie'
             ])
             ->assertSee('Exercise 06');
    }

    public function test_calculate_without_watch()
    {
        $this->post('/exercise06', [
            'bill' => 5000
        ])
             ->assertStatus(302)
             ->assertRedirect('/')
             ->assertSessionHas('result', [
                 'time' => 120
             ]);
    }

    public function test_calculate_with_watch()
    {
        $this->post('/exercise06', [
            'bill' => 5000,
            'has_watch' => true,
        ])
             ->assertStatus(302)
             ->assertRedirect('/')
             ->assertSessionHas('result', [
                 'time' => 300
             ]);
    }

    public function test_calculate_bill_invalid()
    {
        $this->post('/exercise06', [
            'bill' => -1,
            'has_watch' => true,
        ])
             ->assertSessionHasErrors('bill');
    }
}
