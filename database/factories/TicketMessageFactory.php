<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer'        => $this->faker->paragraph,
            'user_id'       => rand(2, 5),
            'ticket_id'     => Ticket::all()->random()->id,
        ];
    }
}
