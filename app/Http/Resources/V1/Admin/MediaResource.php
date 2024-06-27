<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Spatie\MediaLibrary\MediaCollections\Models\Media */
class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'type' => $this->type,
            'extension' => $this->extension,
            'human_readable_size' => $this->humanReadableSize,
            'preview_url' => $this->preview_url,
            'original_url' => $this->original_url,
            'size' => $this->size,
        ];
    }
}
