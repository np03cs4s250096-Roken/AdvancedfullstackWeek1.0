<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('duration');                       // weeks, no negatives
            $table->decimal('fee', 8, 2);                              // 8 digits total, 2 after the point
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard']);    // only these 3 values allowed
            $table->boolean('is_active')->default(true);               // true/false, default true
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};