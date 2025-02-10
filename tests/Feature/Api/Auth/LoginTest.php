<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should auth user', function () {

    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'e2e_test',
    ];
    postJson(route('auth.login'),  $data)
        ->assertOk()
        ->assertJsonStructure(['token']);
});


it('should fail auth - with wrhong password', function () {

    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'wrong-password',
        'device_name' => 'e2e_test',
    ];
    postJson(route('auth.login'),  $data)
        ->assertStatus(422);
});


it('should fail auth - with wrhong email', function () {

    $user = User::factory()->create();

    $data = [
        'email' => 'emailfake@gmail.com',
        'password' => 'password',
        'device_name' => 'e2e_test',
    ];
    postJson(route('auth.login'),  $data)->assertStatus(422);
});
