<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getFilteredAndSorted($request->all());

        return new TaskCollection($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|integer|exists:status,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        $task = $this->taskService->store($validated);

        return new TaskResource($task);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'sometimes|required|integer|exists:status,id',
            'due_date' => 'nullable|date',
            'priority' => 'sometimes|required|string|in:low,medium,high',
        ]);

        $task = $this->taskService->update($id, $validated);

        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }
}
