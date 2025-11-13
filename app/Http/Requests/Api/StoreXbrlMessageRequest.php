<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreXbrlMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message_uuid' => ['required', 'string', 'unique:xbrl_messages,message_uuid'],
            'message_type' => ['nullable', 'string', 'max:255'],
            'message_content' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'message_uuid.required' => 'Het message UUID veld is verplicht.',
            'message_uuid.uuid' => 'Het message UUID moet een geldig UUID formaat hebben.',
            'message_uuid.unique' => 'Dit message UUID bestaat al.',
            'message_content.required' => 'Het message content veld is verplicht.',
        ];
    }
}
