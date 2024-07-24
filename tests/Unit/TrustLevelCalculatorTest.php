<?php

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Event;
use App\Modules\Participation\EventCategory;
use App\Modules\Participation\Services\CalculateTrustLevel;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\AllTime;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\Last3Events;
use App\Modules\Participation\Services\CalculateTrustLevel\AttendeeStorages\OneMonth;

describe('CalculateTrustLevel', function () {
    beforeEach(function () {
        Player::truncate();
    });

    test('should calculate the rate of commitment percentage [1]', function () {
        $player = Player::factory()->create();
        Attendee::factory(5)->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
        ]);

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id);

        expect($result)->toBe('100');
    });

    test('should calculate the rate of commitment percentage [2]', function () {
        $player = Player::factory()->create();
        Attendee::factory(2)->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
        ]);
        Attendee::factory(2)->create([
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
        ]);
        Attendee::factory(3)->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
        ]);

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id);

        expect($result)->toBe('71.43');
    });

    test('should throw when the player didnt attend to any event', function () {
        $player = Player::factory()->create();

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $calculateTrustLevel->player($player->id);
    })
        ->throws(\App\Exceptions\NonFatalException::class);

    test('should not calculate event that didnt happen yet', function () {
        $player = Player::factory()->create();

        // event in the past
        $eventPast = Event::factory()->create(['date' => now()->subDay()->toISOString()]);
        Attendee::factory(3)->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
            'event_id' => $eventPast->id,
        ]);

        // event in the future
        $eventFuture = Event::factory()->create(['date' => now()->addDay()->toISOString()]);
        Attendee::factory(3)->create([
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
            'event_id' => $eventFuture->id,
        ]);

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id);

        expect($result)->toBe('100');
    });

    test('OneMonth modifier', function () {
        $player = Player::factory()->create();

        // one event in this month
        Attendee::factory()->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
            'event_id' => Event::factory()
                ->create(['date' => now()->subWeek()->toISOString()])
                ->id,
        ]);

        // one event older than 2 months
        Attendee::factory()->create([
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
            'event_id' => Event::factory()
                ->create(['date' => now()->subMonths(2)->toISOString()])
                ->id,
        ]);

        // one event in 1 month
        Attendee::factory()->create([
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
            'event_id' => Event::factory()
                ->create(['date' => now()->addMonth()->toISOString()])
                ->id,
        ]);

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id, attendeeStorage: new OneMonth());

        expect($result)->toBe('100');
    });

    test('Last3Events modifier', function () {
        $player = Player::factory()->create();

        Event::factory(2)
            ->create(['date' => now()->subWeek()->toISOString()])
            ->each(function (Event $event) use ($player) {
                Attendee::factory()->create([
                    'is_commitment_fulfilled' => false,
                    'player_id' => $player->id,
                    'event_id' => $event->id,
                ]);
            });
        Event::factory(3)
            ->create(['date' => now()->subDay()->toISOString()])
            ->each(function (Event $event) use ($player) {
                Attendee::factory()->create([
                    'is_commitment_fulfilled' => true,
                    'player_id' => $player->id,
                    'event_id' => $event->id,
                ]);
            });
        Event::factory()
            ->create(['date' => now()->addDay()->toISOString()])
            ->each(function (Event $event) use ($player) {
                Attendee::factory()->create([
                    'is_commitment_fulfilled' => false,
                    'player_id' => $player->id,
                    'event_id' => $event->id,
                ]);
            });

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id, attendeeStorage: new Last3Events());

        expect($result)->toBe('100');
    });

    test('should work with categories', function () {
        $player = Player::factory()->create();
        $categories = EventCategory::factory(3)->create();

        $event1 = Event::factory()->create();
        $event1->categories()->attach($categories->pluck('id'));

        $event2 = Event::factory()->create();
        $event2->categories()->attach($categories[0]->id);

        Attendee::factory()->create([
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
            'event_id' => $event1->id,
        ]);

        Attendee::factory()->create([
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
            'event_id' => $event2->id,
        ]);

        $result1 = resolve(CalculateTrustLevel::class)
            ->player($player->id, $categories->pluck('id')->toArray(), new AllTime());
        $result2 = resolve(CalculateTrustLevel::class)
            ->player($player->id, [$categories[0]->id, $categories[1]->id], new AllTime());
        $result3 = resolve(CalculateTrustLevel::class)
            ->player($player->id, [$categories[0]->id], new AllTime());

        expect($result1)->toBe('100');
        expect($result2)->toBe('100');
        expect($result3)->toBe('50');
    });
});
