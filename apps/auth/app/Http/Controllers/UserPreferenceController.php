<?php

namespace App\Http\Controllers;

use App\Enums\UserSettings;
use App\Models\Interest;
use Illuminate\Http\Request;


class UserPreferenceController extends Controller
{
    /**
     * Get all user settings
     *
     */
    public function __invoke(Request $request)
    {
        $setting = collect(UserSettings::cases())
            ->map(function (UserSettings $setting) {
                $key = auth()->user()->settings()->get($setting);

                return match ($setting) {
                    UserSettings::MOST_FAVORITES => [
                        $setting->value => collect($key)->map(fn($favorite) => Interest::find($favorite)->name),
                    ],
                    UserSettings::LEAST_FAVORITE => [
                        $setting->value => Interest::find($key)->name,
                    ],
                    default => [
                        $setting->value => auth()->user()->settings()->get($setting->value),
                    ],
                };
            });


        return response()->json([
            'data' => $setting,
        ]);
    }

}
