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

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
