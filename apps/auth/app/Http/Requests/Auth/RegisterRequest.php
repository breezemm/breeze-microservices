<?php

namespace App\Http\Requests\V1\Auth;

use App\Rules\Base64ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'gender' => 'required|in:male,female',
            'interests' => 'required|array',
            'profile_image' => ['required', new Base64ValidationRule()],
            'accept_terms' => 'required|accepted',
            'city_id' => 'required|exists:city_lists,id',
            'least_favorite' => 'required|numeric|exists:interests,id',
        ];
    }
}
