<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ai_message_id')->nullable()->constrained('ai_messages')->nullOnDelete();
            $table->string('path');
            $table->string('mime_type', 100);
            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_attachments');
    }
};
