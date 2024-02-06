<?php

namespace App\Enums;

enum NotificationType: string
{
    case NewFollower = 'new_follower';

    case PostLiked = 'post_liked';

    case PostCommented = 'post_commented';

    case PostShared = 'post_shared';

    case CommentLiked = 'comment_liked';

    case CommentReplied = 'comment_replied';


    case TicketSold = 'ticket_sold';

    case EventInvitation = 'event_invitation';

    case EventInvitationAccepted = 'event_invitation_accepted';

    case WalletCashIn = 'wallet_cash_in';

    case WalletCashOut = 'wallet_cash_out';

    case WalletTransfer = 'wallet_transfer';


}
