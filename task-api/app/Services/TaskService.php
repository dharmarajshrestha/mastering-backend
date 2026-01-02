<?php

namespace App\Services;

use App\Models\Task;

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
        $task->complete();

        $task->save();

        return $task;
    }
}
