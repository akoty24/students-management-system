<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
        
            'student' => new StudentResource($this->student),
            'course' => new CourseResource($this->course),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d')

        ];
    }
}
