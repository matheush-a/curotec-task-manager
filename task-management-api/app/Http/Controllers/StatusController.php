<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Response;

class StatusController extends Controller
{
    protected $status;

    public function __construct (Status $status)
    {
        $this->status = $status;
    }

    public function index()
    {
        $data = $this->status->index();
        return $data;
    }
}
