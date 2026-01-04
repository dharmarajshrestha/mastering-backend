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

        if($task->user) {
            Notification::send($task->user, new TaskCreated($task));
        }

        Log::info('Task created notification sent.');

        return $task;
    }

    public function complete(Task $task): Task
    {
        $completionHandler = $this->resolver->resolve($task);

        if(!$completionHandler) {
            throw new \RuntimeException('No handler found for $task');
        }

        $completionHandler->complete();

        $task->save();

        Log::info('Task completed notification sent');

        return $task;
    }
}
