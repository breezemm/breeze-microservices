<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationSendRequest extends FormRequest
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
            'notification_id' => 'required|exists:notification_types,notification_id',
            'user' => 'required|array',
            'user.user_id' => 'required|exists:users,user_id',
            'user.email' => 'nullable|email',
            'user.phone_number' => 'nullable|string',

            'channels' => 'nullable|array',
            'channels.push' => 'nullable|array',
            'channels.push.title' => 'required|string',
            'channels.push.body' => 'required|string',
            'channels.push.data' => 'nullable|array',

        ];
    }
}
