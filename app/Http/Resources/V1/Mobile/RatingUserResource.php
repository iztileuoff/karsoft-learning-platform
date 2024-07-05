<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class RatingUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'post_id' => $this->post_id,
            'post' => new PostResource($this->whenLoaded('post')),
            'school_id' => $this->school_id,
            'school' => new SchoolResource($this->whenLoaded('school')),
            'tests_avg_percent' => $this->tests_avg_percent ?? 0,
        ];
    }
}
