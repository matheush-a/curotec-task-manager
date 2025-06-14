<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->transform(function ($status) {
            return new StatusResource($status);
        })->toArray();
    }
}
