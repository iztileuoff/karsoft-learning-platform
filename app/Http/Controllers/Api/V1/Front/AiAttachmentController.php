<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Actions\Ai\UploadAttachmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\UploadAttachmentRequest;
use App\Http\Resources\V1\Front\AiAttachmentResource;

class AiAttachmentController extends Controller
{
    public function __construct(private readonly UploadAttachmentAction $action) {}

    public function store(UploadAttachmentRequest $request): AiAttachmentResource
    {
        $attachment = $this->action->execute(
            $request->user(),
            $request->file('file'),
        );

        return new AiAttachmentResource($attachment);
    }
}
