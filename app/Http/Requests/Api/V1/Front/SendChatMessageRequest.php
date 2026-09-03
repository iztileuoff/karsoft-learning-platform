<?php

namespace App\Http\Requests\Api\V1\Front;

use App\DTO\Ai\SendChatMessageData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SendChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message'           => ['required', 'string', 'max:10000'],
            'conversation_id'   => ['nullable', 'integer', 'exists:ai_conversations,id'],
            'client_message_id' => ['nullable', 'string', 'max:100'],
            'attachment_ids'    => ['nullable', 'array'],
            'attachment_ids.*'  => ['integer'],
        ];
    }

    public function toData(string $source = 'front'): SendChatMessageData
    {
        return new SendChatMessageData(
            message:         $this->string('message'),
            clientMessageId: $this->string('client_message_id') ?: (string) Str::uuid(),
            source:          $source,
            conversationId:  $this->integer('conversation_id') ?: null,
            attachmentIds:   $this->array('attachment_ids') ?? [],
        );
    }
}
