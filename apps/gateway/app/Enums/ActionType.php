<?php

namespace App\Enums;

enum ActionType: string
{
    case Create = 'create';


    case Comment = 'comment';

    case Like = 'like';

    case Bookmark = 'bookmark';
    case Repost = 'repost';
}
