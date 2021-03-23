<?php

namespace Modules\Exercise08\Tests\Feature;

use Tests\TestCase;

class TicketTest extends TestCase
{
    public function test_view_render()
    {
        $this->get('/exercise08')
             ->assertStatus(200)
             ->assertViewIs('exercise08::index')
             ->assertSee('Exercise08');
    }

    public function test_calculate_valid()
    {
        $this->post('/exercise08/calculate', [
            'name' => 'Hieu',
            'age' => 15,
            'gender' => 'male',
            'booking_date' => '01/03/2021',
        ])
             ->assertStatus(302)
             ->assertRedirect('/')
             ->assertSessionHas('data_success', [
                 'age' => 15,
                 'name' => 'Hieu',
                 'gender' => 'male',
                 'booking_date' => '01/03/2021',
                 'price' => 1800,
             ]);
    }

    public function test_calculate_input_invalid_required()
    {
        $this->post('/exercise08/calculate', [
            'name' => null,
            'age' => null,
            'gender' => null,
            'booking_date' => null,
        ])
            ->assertSessionHasErrors(['name', 'gender', 'age', 'booking_date'])
            ->assertStatus(302)
            ->assertRedirect('/');
    }
}
