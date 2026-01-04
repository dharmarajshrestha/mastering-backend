<?php

namespace App\TaskCompletion;

use App\Contracts\TaskCompletion;
use App\Contracts\TaskTypes\ApprovalTaskCompletion;
use App\Contracts\TaskTypes\SimpleTaskCompletion;
use App\Contracts\TaskTypes\TimedTaskCompletion;
use App\Models\Task;
use InvalidArgumentException;

class TaskCompletionResolver
{
    public function resolve(Task $task): TaskCompletion
    {
        return  match ($task->type) {
            'simple' => new SimpleTaskCompletion($task),
            'timed' => new TimedTaskCompletion($task),
            'approval' => new ApprovalTaskCompletion($task),
            'default' => throw new \InvalidArgumentException(
                "Unknown task type: {$task->type}"
            )
        };
    }
}
