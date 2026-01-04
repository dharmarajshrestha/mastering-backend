<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Response;

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

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create($request->validated());

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function complete(string $id)
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
