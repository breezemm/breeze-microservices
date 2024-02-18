# Notification Service

The notification service is responsible for sending notifications to users. It is a microservice that is part of the
larger microservices architecture of the application.

## Events Listened

The notification service listens to the following events:

### users.identify

This event is used to identify a user. The event payload should be in the following format:

#### Payload

```php
[
    'user_id' => 1,
    'email' => 'aungmyatmoe@breeze.com',
    'phone' => '09790000000',
]
```

| Field   | Type   | Description                   | Required |
| ------- | ------ | ----------------------------- | -------- |
| user_id | int    | The user id.                  | ✅       |
| email   | string | The email of the user.        | Optional |
| phone   | string | The phone number of the user. | Optional |

### notifications.send

This event is used to send a notification to a user. The event payload should be in the following format:

#### Payload

```php
[
    'notification_id' => 'event_joined',
    'user' => [
        'user_id' => 1,
    ],
    'channels' => [
        'push' => [
            'title' => 'Join Event',
            'body' => 'You have joined the event',
            'data' => [
                'type' => 'event_joined',
                'user' => auth()->user()->load('media')->get(),
                'content' => 'joins',
                'event' => $this->order->event,
            ]
        ]
    ],
]
```

| Field               | Type   | Description                                                                                                                            | Required |
| ------------------- | ------ | -------------------------------------------------------------------------------------------------------------------------------------- | -------- |
| notification_id     | string | The [Notification ID](#notification-types) is used to send the notification type of the user who is subscribed to that notifcation ID. | ✅       |
| user                | array  | The user to send the notification to. This should contain the user id.                                                                 | ✅       |
| channels            | array  | The channels to send the notification to. This should contain the channel type and the notification payload.                           | ✅       |
| channels.push       | array  | The push notification payload.                                                                                                         | ✅       |
| channels.push.title | string | The title of the push notification.                                                                                                    | ✅       |
| channels.push.body  | string | The body of the push notification.                                                                                                     | ✅       |
| channels.push.image | string | The image URL                                                                                                                          | Optional |
| channels.push.data  | array  | The data to send with the push notification.                                                                                           | Optional |

## [Notification Types](#notification-types)

The notification service supports the following notification types:
You must provide `notification_id` in the payload to send the notification.

| Notification Name       | Notification ID           | Description                                                                          |
| ----------------------- | ------------------------- | ------------------------------------------------------------------------------------ |
| NewFollower             | new_follower              | User has a new follower                                                              |
| PostLiked               | post_liked                | post liked                                                                           |
| PostCommented           | post_commented            | post commented                                                                       |
| PostShared              | post_shared               | post shared                                                                          |
| CommentLiked            | comment_liked             | comment liked                                                                        |
| CommentReplied          | comment_replied           | comment replied                                                                      |
| TicketSold              | ticket_sold               | When a customer is bought a ticket, notify the seller                                |
| EventJoined             | event_joined              | When a new user joins an event send a notification to all users who joined the event |
| EventInvitation         | event_invitation          | event invitation                                                                     |
| EventInvitationAccepted | event_invitation_accepted | event invitation accepted                                                            |
| WalletCashIn            | wallet_cash_in            | wallet cash in                                                                       |
| WalletCashOut           | wallet_cash_out           | wallet cash out                                                                      |
| WalletTransfer          | wallet_transfer           | wallet transfer                                                                      |
