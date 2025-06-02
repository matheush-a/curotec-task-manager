<?php

namespace App\Services;

use App\Models\Status;

class StatusService
{
    protected $status;

    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    public function getAll()
    {
        return $this->status->with('tasks')->get();
    }
}
