<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketStatus;
use App\Models\User;
use Database\Factories\TicketMessageFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        User::factory(100)->create()->each(function ($user)
        {
            $user->roles()->attach(Role::IS_USER);
        });
        $this->call(TicketStatusTableSeeder::class);
        Ticket::factory(150)->create();
        TicketMessage::factory(150)->create();
    }
}
