<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingsRequest extends FormRequest
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
            'user_id' => 'required|exists:users,user_id',
            'notification_types' => 'required|array',
            'notification_types.*.notification_id' => 'required|string',
            'notification_types.*.settings' => 'required|array',
            'notification_types.*.settings.channels' => 'required|array',
            'notification_types.*.settings.channels.push' => 'nullable|array',
            'notification_types.*.settings.channels.push.enabled' => 'required|boolean',
            'notification_types.*.settings.channels.push.frequency' => 'required|string',
            'notification_types.*.settings.channels.email' => 'nullable|array',
            'notification_types.*.settings.channels.email.enabled' => 'nullable|boolean',
            'notification_types.*.settings.channels.email.frequency' => 'nullable|string',
        ];
    }
}
