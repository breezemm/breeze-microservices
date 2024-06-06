<?php

namespace App\Http\Controllers;

use App\Enums\UserSettings;
use App\Models\Interest;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $setting = collect(UserSettings::cases())
            ->map(function ($setting) {
                $key = auth()->user()->settings()->get($setting);

                if ($setting === UserSettings::MOST_FAVORITES) {
                    return [
                        $setting->value => collect($key)->map(fn($favorite) => Interest::find($favorite)->name),
                    ];
                }

                if ($setting === UserSettings::LEAST_FAVORITE) {
                    return [
                        $setting->value => Interest::find($key)->name,
                    ];
                }
                return [
                    $setting->value => $key,
                ];
            });

        return response()->json([
            'data' => $setting,
        ]);
    }
}
