<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)
            ->hasTasks(Task::factory()->simple()->count(2))
            ->create();

        User::factory(5)
            ->hasTasks(Task::factory()->timed()->count(2))
            ->create();

        User::factory(5)
            ->hasTasks(Task::factory()->approval()->count(2))
            ->create();

        User::factory(5)
            ->hasTasks(
                Task::factory()->approval()->completed()->count(3)
            )
            ->create();
    }
}
