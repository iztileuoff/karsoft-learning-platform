<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('quiz_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('started_at')->nullable()->useCurrent();
            $table->timestamp('finished_at')->nullable();
            $table->string('time_spent')->nullable();
            $table->unsignedSmallInteger('questions_count')->nullable();
            $table->unsignedSmallInteger('correct_questions_count')->nullable();
            $table->decimal('percent', 5, 2)->nullable();
            $table->json('data_questions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
