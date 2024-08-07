<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\EnrollmentResource;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EnrollmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($enrollment) {
            return new EnrollmentResource($enrollment);
        });
    }
}
