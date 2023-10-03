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
            // Step 1
            'name' => 'required|string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i', //
            'end_time' => 'required|date_format:H:i',
            'place' => 'required',
            'co_organizers' => 'nullable|array|exists:users,id',

            // Step 2
            'image' => ['required', new Base64ValidationRule],
            'description' => 'required|string',

            // Step 3
            'interests' => 'required|array|exists:interests,id',

//            'visibility' => 'nullable|in:public,private,unlisted',
//            'is_shareable' => 'nullable|boolean',
        ];
    }
}
