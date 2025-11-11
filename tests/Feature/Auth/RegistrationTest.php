<?php

test('registration screen can be rendered', function () {
    $this->expectException(\Symfony\Component\Routing\Exception\RouteNotFoundException::class);
    $response = $this->get(route('register'));

});

test('new users can not register', function () {
    $this->expectException(\Symfony\Component\Routing\Exception\RouteNotFoundException::class);
    $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

});
