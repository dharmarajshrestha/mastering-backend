<?php

namespace App\Contracts\TaskTypes;

use App\Contracts\TaskCompletion;
use App\Models\Task;

class ApprovalTaskCompletion implements TaskCompletion
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Task $task)
    {
        //
    }

    public function complete(): void
    {
        if ($this->task->approved === null) {
            throw new \Exception("Task {$this->task->id} cannot be completed without approval");
        }

        $this->task->complete();
    }
}
