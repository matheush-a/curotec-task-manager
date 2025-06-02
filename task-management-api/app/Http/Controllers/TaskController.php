<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        $columns = [
            'pending' => [],
            'in_progress' => [],
            'completed' => [],
            'on_hold' => [],
        ];

        foreach ($tasks as $task) {
            $statusName = strtolower(str_replace(' ', '_', $task->status->name));

            if (array_key_exists($statusName, $columns)) {
                $columns[$statusName][] = $task;
            }
        }

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'columns' => $columns,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|integer|exists:status,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        $this->taskService->store($request->all());

        return redirect()->route('tasks.index');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:status,id',
        ]);

        $this->taskService->update($request, $id);
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $this->taskService->delete($id);

        return redirect()->route('tasks.index');
    }
}
