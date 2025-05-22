<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionBulkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.intent_id' => 'required|exists:chatbot_intents,id',
            '*.question_text' => 'required|string',
            '*.input_key' => 'required|string',
            '*.input_type' => 'nullable|string',
            '*.options' => 'nullable|array',
            '*.is_required' => 'boolean',
            '*.order' => 'required|integer',
            '*.info' => 'nullable|string',
        ];
    }
}
