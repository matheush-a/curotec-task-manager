<?php

namespace App\Models;

use App\Http\Resources\StatusCollection;
use App\Http\Resources\StatusResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'name',
    ];

    public function index() {
        $data = $this->all();
        return new StatusCollection($data);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
