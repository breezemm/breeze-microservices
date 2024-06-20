<?php

namespace App\Enums;

enum UserSettings: string
{
    case MOST_FAVORITES = 'most_favorites';
    case LEAST_FAVORITE = 'least_favorite';
}
