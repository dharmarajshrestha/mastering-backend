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
        public TaskService $taskService
    ) {
        //
    }

    public function index()
    {
        $tasks = Task::simplePaginate(10);

        if (! $tasks) {
            return response()->json([
                'message' => 'No Tasks',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($tasks, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:tasks,name'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:pending,completed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $task = $this->taskService->create($validated);

        Log::info('Task created notification sent.');

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function markAsComplete(string $id)
    {
        $task = Task::find($id);

        if (! $task) {
            return response()->json([
                'message' => 'Task not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->taskService->complete($task);

        Log::info('Task completed notification sent');

        return response()->json([
            'message' => "Task {$task->id} completed",
        ], Response::HTTP_OK);
    }
}
