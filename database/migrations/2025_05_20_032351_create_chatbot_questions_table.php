<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chatbot_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intent_id')->constrained('chatbot_intents')->onDelete('cascade');
            $table->string('question_text');
            $table->string('input_key');
            $table->string('input_type')->nullable();
            $table->json('options')->nullable();
            $table->boolean('is_required')->default('1');
            $table->unsignedInteger('order')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_questions');
    }
};
