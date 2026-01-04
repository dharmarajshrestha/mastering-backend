<?php

namespace App\Contracts\TaskTypes;

use App\Models\Task;
use Carbon\Carbon;

class TimedTaskCompletion
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Task $task)
    {
        //
    }

    public function complete()
    {
        if ($this->task->due_at < Carbon::now()) {
            throw new \Exception("Task {$this->task->id} cannot be completed before due time");
        }

        $this->task->complete();
    }
}
