<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('degree_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
