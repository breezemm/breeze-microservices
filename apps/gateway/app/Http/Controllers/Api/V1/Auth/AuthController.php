<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Jobs\UserCreated;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $data['password'] = Hash::make($data['password']);
            $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
            $data['username'] = Str::slug($data['name'].'_'.Str::random(5), '_');

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

            $token = $user->createToken('access_token')->accessToken;

            UserCreated::dispatch($user->toArray());

            DB::commit();

            return json_response(Response::HTTP_CREATED, 'User has been created successfully', [
                'access_token' => $token,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return json_response(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        $validatedUser = $request->validated();
        $auth = auth()->attempt($validatedUser);
        if (! $auth) {
            return json_response(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid credentials');
        }

        $token = auth()->user()->createToken('access_token')->accessToken;

        return json_response(200, 'User has been logged in successfully', [
            'access_token' => $token,
        ]);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Cache::delete(auth()->user()->username);

        return \response()->noContent();
    }

    public function getAuthUser()
    {
        $user = auth()->user();

        $user
            ->load('interests:id,name')
            ->load('address');

        return Cache::store('redis')->remember(auth()->user()->username, 60 * 60 * 24, function () use ($user) {
            return new UserResource($user);
        });
    }

    public function getProfile(string $username)
    {
        $user = User::whereUsername($username)->firstOrFail();
        auth()->user()->attachFollowStatus($user);

        return response()->json([
            'data' => [
                'events_count' => $user->events()->count(),
                'followers_count' => $user->followers()->count(),
                'followings_count' => $user->followings()->count(),
                'is_auth_user' => auth()->user()->is($user),
                'user' => new UserResource($user),
            ],
        ]);
    }
}
