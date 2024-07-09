<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Test */
class TestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quiz_id' => $this->quiz_id,
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),
            'finished_at' => $this->finished_at?->format('Y-m-d H:i:s'),
            'time_spent' => $this->time_spent,
            'questions_count' => $this->questions_count,
            'correct_answers_count' => $this->correct_answers_count,
            'percent' => $this->percent,
        ];
    }
}
