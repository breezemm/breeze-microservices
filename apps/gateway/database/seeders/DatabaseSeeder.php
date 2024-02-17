<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\ActionType;
use App\Models\Activity;
use App\Models\CityList;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Repost;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IntrestSeeder::class,
            CityListSeeder::class,
        ]);

        User::factory()->count(10)
            ->hasAttached(
                Interest::all()->random(3),
                [
                    'least_favorite_id' => 9,
                ],
            )
            ->create()
            ->each(
                fn (User $user) => $user
                    ->events()->saveMany(
                        Event::factory()
                            ->count(3)->make()
                    ),
            );

        User::all()
            ->each(
                fn (User $user) => $user->address()->create([
                    'city_list_id' => CityList::all()->random()->id,
                ])
            );

        Event::all()
            ->each(
                fn (Event $event) => $event->interests()->attach(
                    Interest::all()->random(3)
                ),
            );

        Activity::create([
            'action_type' => ActionType::Create,
            'user_id' => 11,
            'event_id' => 4,
        ]);

        Activity::create([
            'action_type' => ActionType::Like, // like
            'user_id' => 11,
            'event_id' => 5,
        ]);

        Activity::create([
            'action_type' => ActionType::Bookmark, // bookmark
            'user_id' => 11,
            'event_id' => 5,
        ]);

        Activity::create([
            'action_type' => ActionType::Comment, // bookmark
            'user_id' => 11,
            'event_id' => 8,
        ]);
        Event::find(8)->comments()->create([
            'comment' => 'comment content',
            'user_id' => 11,
        ]);

        //        when user repost something, it will create activity and repost
        Activity::create([
            'action_type' => ActionType::Repost, // repost
            'user_id' => 11,
            'event_id' => 5,
        ]);
        Repost::create([
            'user_id' => 11,
            'event_id' => 5,
            'content' => 'repost content',
        ]);

        Activity::create([
            'action_type' => ActionType::Create,
            'user_id' => 1,
            'event_id' => 1,
        ]);
        Activity::create([
            'action_type' => ActionType::Create,
            'user_id' => 1,
            'event_id' => 2,
        ]);

    }
}
