<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TicketStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TicketStatus::truncate();
        Schema::enableForeignKeyConstraints();

        TicketStatus::create(['name' => 'Open']);
        TicketStatus::create(['name' => 'Closed w/o solution']);
        TicketStatus::create(['name' => 'Closed with solution']);
    }
}
