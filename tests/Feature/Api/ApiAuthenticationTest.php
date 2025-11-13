<?php

use App\Models\User;

test('unauthenticated api request returns json 401 response', function () {
    $response = $this->getJson('/api/user');

    $response->assertUnauthorized()
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});

test('authenticated api request with token returns user data', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->getJson('/api/user', [
        'Authorization' => "Bearer {$token}",
    ]);

    $response->assertSuccessful()
        ->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
});
