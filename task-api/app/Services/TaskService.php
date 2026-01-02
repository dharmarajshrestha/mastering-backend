<?php

namespace App\Services;

use App\Models\Task;
use Exception;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function complete(Task $task): Task
    {
        if ($task->status === 'completed') {
            throw new Exception("Task {$task->id} already completed");
        }

        $task->status = 'completed';
        
        $task->save();

        return $task;
    }
}
