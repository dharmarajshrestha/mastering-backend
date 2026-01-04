<?php

namespace App\Contracts;

use App\Models\Task;

interface TaskCompletion
{
    public function complete(): void;
}
