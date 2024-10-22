<?php

namespace App\Http\Controllers;

use App\Enums\StorageMediaCollectionName;
use App\Enums\UserSettings;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class AuthController extends Controller
{
    /**
     * @unauthenticated
     * Register a new user
     *
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request)
    {

        $data = $request->validated();

        $data['password'] = Hash::make($request->password);
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
        $data['username'] = Str::snake($data['name'] . Str::random(5));

        try {
            DB::beginTransaction();
            $user = User::create($data);

            $user->addMediaFromBase64($request->validated('user_profile_image'))
                ->toMediaCollection(StorageMediaCollectionName::PROFILE_IMAGES->value);


            $mostFavorites = $request->validated('most_favorites');

            $user->settings()->set(UserSettings::MOST_FAVORITES, $mostFavorites);

            $user->settings()->set(UserSettings::LEAST_FAVORITE, $request->validated('least_favorite'));


            $user->markEmailAsVerified();

            $accessToken = $user->createToken('access_token')->accessToken;

            DB::commit();

            return response()->json([
                'message' => 'User has been registered successfully',
                'data' => [
                    'access_token' => $accessToken,
                ],
            ]);
        } catch (Exception|FileCannotBeAdded $exception) {
            DB::rollBack();

            Log::error("User registration failed" . $exception->getMessage());

            return response()->json([
                'message' => 'User registration failed',
            ]);
        }
    }


    /**
     * @unauthenticated
     *
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $validatedUser = $request->validated();
        $auth = auth()->attempt($validatedUser);

        abort_if(!$auth, 401, 'Invalid credentials');

        $accessToken = auth()->user()->createToken('access_token')->accessToken;

        return response()->json([
            'message' => 'User has been logged in successfully',
            'data' => [
                'access_token' => $accessToken,
            ],
        ]);

    }

    /**
     * @authenticated
     *
     * Logout a user
     *
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->noContent();
    }

    /**
     * @authenticated
     *
     * Get the current authenticated user
     *
     * @return JsonResponse
     */
    public function getCurrentAuthUser()
    {
        $user = auth()->user();

        return $this->getUserProfileByUsername($user->username);
    }


    public function getUserProfileByUsername(string $username)
    {
        $user = User::whereUsername($username)->firstOrFail();

        $user->load('city');


        return response()->json([
            'data' => [
                'is_auth_user' => auth()->user()->is($user),
                'user' => new UserResource($user),
            ],
        ]);
    }
}
