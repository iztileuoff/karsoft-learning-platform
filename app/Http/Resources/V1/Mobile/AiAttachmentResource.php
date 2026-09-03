<?php

namespace App\Http\Resources\V1\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin \App\Models\AiAttachment */
class AiAttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'original_name' => $this->original_name,
            'mime_type'     => $this->mime_type,
            'size'          => $this->size,
            'url'           => Storage::disk('public')->url($this->path),
            'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
