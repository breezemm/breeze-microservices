<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\CreateWalletAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $data['password'] = Hash::make($data['password']);
            $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
            $data['username'] = Str::slug($data['name'] . '_' . Str::random(5), '_');

            DB::beginTransaction();
            $user = User::create($data);

            $user->addMediaFromBase64($data['profile_image'])
                ->toMediaCollection('profile-images');

            $user->address()->create([
                'city_list_id' => $data['city_id'],
            ]);

            $user->interests()->attach($data['interests'], [
                'least_favorite_id' => $data['least_favorite'],
            ]);

            $accessToken = $user->createToken('access_token')->accessToken;

            //            TODO: Uncomment this line to create wallet for user
            //                        (new CreateWalletAction)->handle($user);
            //            TODO: Uncomment this line to identify user
            //            (new IdentifyUserAction)->handle($user);

            DB::commit();

            return response()->json([
                'message' => 'User has been registered successfully',
                'data' => [
                    'access_token' => $accessToken,
                ],
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error($exception->getMessage());

            return response()->json([
                'message' => 'User registration failed',
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        $validatedUser = $request->validated();
        $auth = auth()->attempt($validatedUser);

        abort_if(! $auth, 401, 'Invalid credentials');

        $accessToken = auth()->user()->createToken('access_token')->accessToken;

        return response()->json([
            'message' => 'User has been logged in successfully',
            'data' => [
                'access_token' => $accessToken,
            ],
        ]);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Cache::delete(auth()->user()->username);

        return response()->noContent();
    }

    public function getAuthUser()
    {
        $user = auth()->user();

        $user
            ->load('interests:id,name')
            ->load('address');

        return $this->getUserProfileByUsername($user->username);
    }

    public function getUserProfileByUsername(string $username)
    {
        $user = User::whereUsername($username)->firstOrFail();
        auth()->user()->attachFollowStatus($user);

        return Cache::remember($user->username, 60 * 60 * 24, fn () => response()->json([
            'data' => [
                'events_count' => $user->events()->count(),
                'followers_count' => $user->followers()->count(),
                'followings_count' => $user->followings()->count(),
                'is_auth_user' => auth()->user()->is($user),
                'user' => new UserResource($user),
            ],
        ]));

    }
}
