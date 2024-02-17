<?php

namespace App\Enums;

enum UserActionTypeEnum: string
{
    case Create = 'create';

    case Comment = 'comment';

    case Like = 'like';

    case Bookmark = 'bookmark';
    case Repost = 'repost';
}
