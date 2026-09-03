<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('reply_to_id')->nullable();
            $table->string('role', 10);
            $table->longText('content')->nullable();
            $table->string('status', 15)->default('pending');
            $table->string('client_message_id', 100)->nullable();
            $table->string('model', 80)->nullable();
            $table->unsignedInteger('prompt_tokens')->nullable();
            $table->unsignedInteger('completion_tokens')->nullable();
            $table->unsignedInteger('total_tokens')->nullable();
            $table->string('finish_reason', 30)->nullable();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->string('error', 1000)->nullable();
            $table->timestamps();

            $table->index(['ai_conversation_id', 'status']);
            $table->unique(['ai_conversation_id', 'client_message_id']);
            $table->foreign('reply_to_id')->references('id')->on('ai_messages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_messages');
    }
};
