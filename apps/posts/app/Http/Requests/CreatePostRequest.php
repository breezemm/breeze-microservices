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
        /**
         * A post has many phases
         * A phase has many ticket types
         * A ticket type has many tickets (seats) if it has a seating plan
         */
        return [
            // Step 1
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'address' => 'required',
            'city' => 'required',
            'co_organizers' => 'nullable|array|exists:users,id',
            'interests' => 'required|array',
            'image' => ['required', new Base64ValidationRule],
            'description' => 'required|string',

            'ticket_types' => 'required|array',
            'ticket_types.*.name' => 'required|string',
            'ticket_types.*.quantity' => 'required|integer', // if quantity is 0, it means unlimited
            'ticket_types.*.benefits' => 'nullable|array',
            'ticket_types.*.price' => 'nullable|numeric', // if price is null, it means free

            'ticket_types.*.phases' => 'nullable|array',
            'ticket_types.*.phases.*.name' => 'required|string',
            'ticket_types.*.phases.*.start_date' => 'required|date_format:Y-m-d',
            'ticket_types.*.phases.*.end_date' => 'required|date_format:Y-m-d',
            'ticket_types.*.phases.*.price' => 'required|numeric',


            // terms confirmation
            'terms' => 'required|boolean',

        ];
    }
}
