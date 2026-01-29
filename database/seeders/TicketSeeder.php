<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['open', 'in_progress', 'closed'];
        $users = User::all();
        foreach (range(1, 10) as $i) {
            Ticket::create([
                'title' => "Sample Ticket Title $i",
                'description' => "This is a description for ticket number $i.",
                'status' => $statuses[array_rand($statuses)],
                'user_id' => $users->random()->id,
                'unit_id' => rand(1, 3), // Assuming there are 3 units seeded
            ]);
        }
    }
}
