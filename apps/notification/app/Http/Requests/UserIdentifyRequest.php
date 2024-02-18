<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIdentifyRequest extends FormRequest
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
            'user_id' => 'required|unique:users,user_id', // The ID of the user in your system. Required.
            'email' => 'nullable|email',
            'phone_number' => 'nullable|regex:/^\+[1-9]\d{1,14}$/',

            'push_tokens' => 'nullable|array',
            'push_tokens.*.type' => 'required|in:FCM,APN',
            'push_tokens.*.token' => 'required|string',

        ];
    }
}
