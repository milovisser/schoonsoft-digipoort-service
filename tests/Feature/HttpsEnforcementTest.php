<?php

test('http requests are redirected to https', function () {
    $response = $this->get('/', [
        'HTTP_X_FORWARDED_PROTO' => 'http',
    ]);

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toStartWith('https://');
});

test('https requests are allowed', function () {
    $response = $this->get('/', [
        'HTTP_X_FORWARDED_PROTO' => 'https',
    ]);

    $response->assertStatus(200);
});

test('urls are generated with https scheme', function () {
    $url = route('login');

    expect($url)->toStartWith('https://');
});
