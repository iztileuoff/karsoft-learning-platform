<?php

namespace App\Actions\Ai;

use App\Models\AiAttachment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UploadAttachmentAction
{
    public function execute(User $user, UploadedFile $file): AiAttachment
    {
        $extension = $file->getClientOriginalExtension();
        $filename  = Str::uuid() . '.' . $extension;
        $directory = 'ai-attachments/' . $user->id;

        $path = Storage::disk('public')->putFileAs($directory, $file, $filename);

        return AiAttachment::create([
            'user_id'       => $user->id,
            'path'          => $path,
            'mime_type'     => $file->getMimeType(),
            'original_name' => $file->getClientOriginalName(),
            'size'          => $file->getSize(),
        ]);
    }
}
