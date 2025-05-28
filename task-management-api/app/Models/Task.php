<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $fillable = [
        'title',
        'description',
        'status_id',
        'due_date',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function index() {
        return $this->all();
    }

    public function store($request) {
        $task = new Task();

        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->status_id = $request['status_id'];
        $task->due_date = $request['due_date'];
        $task->priority = $request['priority'];
        $task->save();

        return $task;
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
