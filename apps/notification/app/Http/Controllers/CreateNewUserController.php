<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIdentifyRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateNewUserController extends Controller
{

    public function __invoke(UserIdentifyRequest $request)
    {
        try {
            DB::beginTransaction();
            User::create([
                'user_id' => $request->validated('user_id'),
                'email' => $request->validated('email'),
                'phone' => $request->validated('phone'),
                'push_tokens' => $request->validated('push_tokens'),
                'web_push_tokens' => $request->validated('web_push_tokens'),
                'settings' => [
                    'channels' => [
                        'email' => [
                            'enabled' => false,
                            'frequency' => 'instant'
                        ],
                        'sms' => [
                            'enabled' => false,
                            'frequency' => 'instant'
                        ],
                        'push' => [
                            'enabled' => true,
                            'frequency' => 'instant'
                        ],
                        'web_push' => [
                            'enabled' => false,
                            'frequency' => 'instant'
                        ]
                    ]
                ]
            ]);
            DB::commit();

            return response()->json([
                'message' => 'User created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'User creation failed. Please try again.',
            ]);
        }
    }

}
