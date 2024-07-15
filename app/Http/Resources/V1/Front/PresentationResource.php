<?php

namespace App\Http\Resources\V1\Front;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Presentation */
class PresentationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'degree_id' => $this->degree_id,
            'file' => new MediaResource($this->getFirstMedia('file')),
            'image_url' => $this->getFirstMediaUrl('image'),
        ];
    }
}
