<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotIntent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'options' => 'array',
    ];

    public function questions()
    {
        return $this->hasMany(ChatbotQuestion::class);
    }
    
    public function responses()
    {
        return $this->hasMany(ChatbotResponse::class);
    }
}