<?php

namespace App\Http\Resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Test */
class TestQuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),
            'questions_count' => $this->questions_count,
            'questions' => $this->getOnlyNumberAndTextQuestionsOptions(),
        ];
    }
}
