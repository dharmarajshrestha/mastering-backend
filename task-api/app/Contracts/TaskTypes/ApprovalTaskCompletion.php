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
        if (!$this->task->isApproved()) {
            throw new \Exception('Task cannot be completed without approval');
        }

        $this->task->complete();
    }
}
