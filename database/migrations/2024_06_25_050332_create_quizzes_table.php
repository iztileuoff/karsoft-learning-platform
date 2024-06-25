<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->ulid('id');
            $table->string('name');
            $table->text('description');
            $table->foreignId('degree_id')->nullable()->constrained()->nullOnDelete();
            $table->string('language');
            $table->unsignedSmallInteger('number_of_questions')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
