<?php

namespace App\Services;

use App\Models\Task;
use App\Notifications\TaskCreated;
use App\TaskCompletion\TaskCompletionResolver;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TaskCompletionResolver $resolver)
    {
        //
    }

    public function create(array $data): Task
    {
        $task = Task::create($data);

        Log::info('Task created notification sent.');

        Notification::send($task->user, new TaskCreated($task));

        return $task;
    }

    public function complete(Task $task): Task
    {
        $resolver = $this->resolver->resolve($task);

        $resolver->complete();

        $task->save();

        Log::info('Task completed notification sent');

        return $task;
    }
}
