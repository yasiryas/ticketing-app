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
        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                Ticket::create([
                    'title' => "Sample Ticket {$i} for {$user->name}",
                    'description' => "This is a description for Sample Ticket {$i} assigned to {$user->name}.",
                    'status' => $statuses[array_rand($statuses)],
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
