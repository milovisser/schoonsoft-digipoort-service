<?php

use App\Models\User;
use App\Models\XbrlMessage;
use Illuminate\Support\Str;

it('allows an authenticated user to store an XBRL message', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $payload = [
        'message_uuid' => (string) Str::uuid(),
        'message_type' => 'VAT',
        'message_content' => '<xbrl>content</xbrl>',
    ];

    $response = $this->postJson('/api/xbrl-messages', $payload, [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'message_uuid',
                'status',
                'created_at',
            ],
        ]);

    expect(
        XbrlMessage::query()->where('message_uuid', $payload['message_uuid'])->exists()
    )->toBeTrue();
});

it('validates the store request payload', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Missing required fields
    $response = $this->postJson('/api/xbrl-messages', [], [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors([
            'message_uuid',
            'message_content',
        ]);
});
