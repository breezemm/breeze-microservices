<?php

namespace App\Http\DataTransferObjects;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            'user_id' => 'required|integer',
        ];
    }
}
