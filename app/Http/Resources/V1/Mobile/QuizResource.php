<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quiz */
class QuizResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'degree_id' => $this->degree_id,
            'degree' => new DegreeResource($this->whenLoaded('degree')),
            'language' => $this->language,
            'questions_count' => $this->whenCounted('questions'),
            'number_of_questions' => $this->number_of_questions,
            'test' => new TestResource($this->whenLoaded('test')),
        ];
    }
}
