<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusCollection;
use App\Services\StatusService;

class StatusController extends Controller
{
    protected $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function index()
    {
        $statuses = $this->statusService->getAll();

        if ($statuses->isEmpty()) {
            return response()->noContent();
        }

        return new StatusCollection($statuses);
    }
}
