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
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|after:start_date|date_format:Y-m-d',
            'end_time' => 'required|date_format:H:i',
            'place' => 'required',
            'co_organizers' => 'nullable|array|exists:users,id',

            // Step 2
            'image' => ['required', new Base64ValidationRule],
            'description' => 'required|string',

            // Step 3
            'interests' => 'required|array|exists:interests,id',

            'is_has_phases' => 'required|boolean', // does event have phases or not,

            'phases' => 'required|array', // a phase is a part of an event
            'phases.*.name' => 'required|string',
            'phases.*.start_date' => 'required|date_format:Y-m-d',
            'phases.*.end_date' => 'required|date_format:Y-m-d',

            // phases have tickets array
            'phases.*.tickets' => 'required|array',
            'phases.*.tickets.*.name' => 'required|string',
            'phases.*.tickets.*.information' => 'required|string',
            'phases.*.tickets.*.price' => 'required|integer',
            'phases.*.tickets.*.is_has_seating_plan' => 'required|boolean',
            'phases.*.tickets.*.total_seats' => 'required_if:phases.*.tickets.*.is_has_seating_plan,true|integer',

        ];
    }
}
