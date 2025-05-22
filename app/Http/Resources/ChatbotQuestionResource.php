<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatbotQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'intent_id' => $this->intent_id,
        'question_text' => $this->question_text,
        'info' => $this->info,
        'input_key' => $this->input_key,
        'input_type' => $this->input_type,
        'options' => $this->options,
        'is_required' => $this->is_required,
        'order' => $this->order,
        ];
    }
}
