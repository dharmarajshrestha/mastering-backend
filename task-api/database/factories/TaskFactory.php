<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'type' => 'simple',
            'status' => 'pending',
        ];
    }

    /**
     * Indicate that the task is simple.
     */
    public function simple(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'simple'
            ];
        });
    }

    /**
     * Indicate that the task is timed.
     */
    public function timed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'timed',
                'due_at' => now()->addDays(rand(1, 7))
            ];
        });
    }

    /**
     * Indicate that the task is approval.
     */
    public function approval(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'approval',
                'approved_at' => now()
            ];
        });
    }

    /**
     * Indicate that the task is approval.
     */
    public function completed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }
}
