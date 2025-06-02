<?php

namespace App\Services;

use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function byId($id)
    {
        return $this->task->with('status')->findOrFail($id);
    }

    public function getFilteredAndSorted(array $filters)
    {
        $query = $this->task->newQuery();
    
        if (!empty($filters['status'])) {
            $query->where('status_id', $filters['status']);
        }
    
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
    
        if (!empty($filters['due_date'])) {
            $query->whereDate('due_date', $filters['due_date']);
        }
    
        if (!empty($filters['sort_by'])) {
            $sortOrder = $filters['sort_order'] ?? 'asc';
            $query->orderBy($filters['sort_by'], $sortOrder);
        }
    
        return $query->with('status')->get();
    }

    public function store(array $data)
    {
        return $this->task->create($data);
    }

    public function update($id, $data)
    {
        $task = $this->byId($id);
        $task->update(['status_id' => $data['status_id']]);

        return $task;
    }

    public function delete($id)
    {
        $task = $this->task->findOrFail($id);
        $task->delete();
    }
}
