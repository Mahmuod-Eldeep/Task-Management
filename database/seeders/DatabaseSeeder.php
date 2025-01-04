<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        // Create a user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create some tasks
        Task::create([
            'title' => 'Task 1',
            'description' => 'Description for Task 1',
            'status' => 'pending',
            'due_date' => now()->addDays(7),
            'user_id' => 2,
        ]);

        Task::create([
            'title' => 'Task 2',
            'description' => 'Description for Task 2',
            'status' => 'pending',
            'due_date' => now()->addDays(14),
            'user_id' => 2,
        ]);
    }
}
