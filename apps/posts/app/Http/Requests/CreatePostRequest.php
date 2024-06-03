<?php

namespace App\Http\Requests;

use App\Rules\Base64ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            // Step 1
            'name' => 'required|string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
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
            'phases.*.name' => 'required|string', // Period Name
            'phases.*.start_date' => 'required|date_format:Y-m-d',
            'phases.*.end_date' => 'required|date_format:Y-m-d',

            // phases have many ticket types
            'phases.*.ticket_types' => 'required|array',
            'phases.*.ticket_types.*.name' => 'required|string',
            'phases.*.ticket_types.*.benefits' => 'nullable|array',
            'phases.*.ticket_types.*.price' => 'required|integer',
            'phases.*.ticket_types.*.is_has_seating_plan' => 'required|boolean',
            'phases.*.ticket_types.*.total_seats' => 'required_if:phases.*.ticket_types.*.is_has_seating_plan,true|integer',

        ];
    }
}
