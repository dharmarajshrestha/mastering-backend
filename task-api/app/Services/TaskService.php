<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

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
        $task = Task::create($data);

        Log::info('Task created notification sent.');

        return $task;
    }

    public function complete(Task $task): Task
    {
        $task->complete();

        $task->save();

        Log::info('Task completed notification sent');

        return $task;
    }
}
