<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {
        //
    }

    public function index()
    {
        $tasks = Task::simplePaginate(10);

        return response()->json($tasks, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:tasks,name'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:pending,completed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'type' => ['required', 'in:simple,timed,approval,locked'],
            'due_at' => ['required','date'],
        ]);

        $task = $this->taskService->create($validated);

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function markAsComplete(string $id)
    {
        $task = Task::find($id);

        if (! $task) {
            throw new \Exception('Task not found');
        }

        $this->taskService->complete($task);

        return response()->json([
            'message' => "Task {$task->id} completed",
        ], Response::HTTP_OK);
    }
}
