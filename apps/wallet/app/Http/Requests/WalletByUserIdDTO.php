<?php

namespace App\Http\Requests;

use Spatie\LaravelData\Data;

class WalletByUserIdDTO extends Data
{

    public function __construct(
        public readonly int $user_id,
    )
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            'user_id' => 'required|integer',
        ];
    }
}
