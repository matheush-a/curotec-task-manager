<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index() 
    {
        $data = $this->task->index();

        if ($data->isEmpty()) {
            return response(Response::HTTP_NO_CONTENT);
        }

        return response(Response::HTTP_OK)->json($data);
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

        $data = $this->task->store($request->all());

        return response(Response::HTTP_CREATED);
    }

    public function update()
    {

    }
}
