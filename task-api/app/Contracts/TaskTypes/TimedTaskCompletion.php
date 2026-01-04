<?php

namespace App\Contracts\TaskTypes;

use App\Models\Task;

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
        if ($this->task->isDueDatePassed()) {
            throw new \Exception('This-> cannot be completed before due time');
        }

        $this->task->complete();
    }
}
