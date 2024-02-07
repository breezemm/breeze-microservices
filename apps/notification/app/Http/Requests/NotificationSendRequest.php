<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

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
            'user.user_id' => 'required|string',
            'user.email' => 'required|string',
            'user.phone_number' => 'required|string',

            'channels' => 'required|array',
            'channels.push' => 'required|array',
            'channels.push.title' => 'required|string',
            'channels.push.body' => 'required|string',
            'channels.push.data' => 'nullable|array',

        ];
    }
}
