<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResponseRequest extends FormRequest
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

    // protected function prepareForValidation()
    // {
    //     if ($this->has('params')) {
    //         // Jika params adalah string, coba decode menjadi array
    //         if (is_string($this->params)) {
    //             $decodedParams = json_decode($this->params, true);
    //             if (json_last_error() === JSON_ERROR_NONE && is_array($decodedParams)) {
    //                 $this->merge([
    //                     'params' => $decodedParams
    //                 ]);
    //             } else {
    //                 // Jika string bukan JSON array yang valid, ubah menjadi array kosong atau berikan default
    //                 $this->merge([
    //                     'params' => []
    //                 ]);
    //             }
    //         }
    //         // Jika params sudah array, encode ke JSON
    //         if (is_array($this->params)) {
    //             $this->merge([
    //                 'params' => json_encode($this->params)
    //             ]);
    //         }
    //     }
    // }
}