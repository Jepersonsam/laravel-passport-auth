<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'intent_id',
        'question_text',
        'info',
        'input_key',
        'input_type',
        'options',
        'is_required',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function intent()
    {
        return $this->belongsTo(ChatbotIntent::class, 'intent_id');
    }
}
