<?php

namespace App\Contracts\TaskTypes;

use App\Models\Task;

class SimpleTaskCompletion
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
        $this->task->complete();
    }
}
