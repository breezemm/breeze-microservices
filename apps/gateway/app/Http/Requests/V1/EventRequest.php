<?php

namespace App\Http\Requests\V1;

use App\Rules\Base64ValidationRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            // step 1
            'event_name' => 'required|string|max:255',
            'day' => 'required|date_format:d',
            'month' => 'required|date_format:m',
            'year' => 'required|date_format:Y',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'place' => 'required',

            // step 2
            'image' => ['required', new Base64ValidationRule],
            'description' => 'required|string',
            'categories' => ['required', 'array'],

            'visibility' => 'nullable|in:public,private,unlisted',
            'is_shareable' => 'nullable|boolean',
        ];
    }
}
