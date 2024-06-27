<?php

namespace App\Http\Resources\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Info */
class InfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text_translations' => $this->getTranslations('text'),
            'text' => $this->text,
            'mobile' => $this->mobile,
        ];
    }
}
