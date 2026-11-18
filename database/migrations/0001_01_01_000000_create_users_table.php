<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();                                 // auto-increment primary key
            $table->string('name');                       // text up to 255 characters
            $table->string('email')->unique();            // no two students can share an email
            $table->string('phone');
            $table->text('address')->nullable();          // long text, can be empty
            $table->date('date_of_birth')->nullable();    // date only, can be empty
            $table->timestamps();                         // adds created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');                 // used when you roll back
    }
};
