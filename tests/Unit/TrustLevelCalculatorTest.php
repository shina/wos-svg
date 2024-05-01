<?php

use App\Models\Player;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Enums\CommitmentLevel;
use App\Modules\Participation\Event;
use App\Modules\Participation\Services\CalculateTrustLevel;

describe('CalculateTrustLevel', function () {
    test('should calculate the rate of commitment percentage [1]', function () {
        $player = Player::factory()->create();
        Attendee::factory(5)->create([
            'commitment_level' => CommitmentLevel::join,
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
            'commitment_level' => CommitmentLevel::join,
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
        ]);
        Attendee::factory(2)->create([
            'commitment_level' => CommitmentLevel::join,
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
        ]);
        Attendee::factory(3)->create([
            'commitment_level' => CommitmentLevel::join,
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
            'commitment_level' => CommitmentLevel::join,
            'is_commitment_fulfilled' => true,
            'player_id' => $player->id,
            'event_id' => $eventPast->id,
        ]);

        // event in the future
        $eventFuture = Event::factory()->create(['date' => now()->addDay()->toISOString()]);
        Attendee::factory(3)->create([
            'commitment_level' => CommitmentLevel::join,
            'is_commitment_fulfilled' => false,
            'player_id' => $player->id,
            'event_id' => $eventFuture->id,
        ]);

        $calculateTrustLevel = resolve(CalculateTrustLevel::class);
        $result = $calculateTrustLevel->player($player->id);

        expect($result)->toBe('100');
    });
});