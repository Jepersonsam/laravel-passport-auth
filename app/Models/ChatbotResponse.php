<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'intent_id',
        'response_text',
        'type',
        'params',
        'value',
    ];

    protected $casts = [
        'params' => 'array', // Langsung definisikan sebagai 'array'
    ];

    public function intent()
    {
        return $this->belongsTo(ChatbotIntent::class);
    }
}