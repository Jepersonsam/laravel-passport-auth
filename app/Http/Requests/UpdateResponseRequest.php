<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'intent_id' => 'required|exists:chatbot_intents,id',
            'response_text' => 'required|string',
            'type' => 'required|string',
            'value' => 'nullable|string',
            'params' => 'nullable|array',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('params')) {
            if (is_string($this->params)) {
                $decoded = json_decode($this->params, true);
                $this->merge([
                    'params' => json_last_error() === JSON_ERROR_NONE ? $decoded : [],
                ]);
            }
        }
    }
}
