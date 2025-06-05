<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatbotResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'intent_id' => $this->intent_id,
            'response_text' => $this->response_text,
            'type' => $this->type, // Tambahan
            'value' => $this->value,
            'params' => $this->params,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
