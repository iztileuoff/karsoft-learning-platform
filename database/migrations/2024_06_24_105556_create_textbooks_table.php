<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('textbooks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->foreignId('degree_id')->nullable()->constrained()->nullOnDelete();
            $table->string('language');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('textbooks');
    }
};
