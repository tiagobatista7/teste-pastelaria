<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('autentica o usuário', function () {

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


it('deve falhar na autenticação - com senha errada', function () {

    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'wrong-password',
        'device_name' => 'e2e_test',
    ];
    postJson(route('auth.login'),  $data)
        ->assertStatus(422);
});


it('deve falhar na autenticação - com e-mail errado', function () {

    $user = User::factory()->create();

    $data = [
        'email' => 'emailfake@gmail.com',
        'password' => 'password',
        'device_name' => 'e2e_test',
    ];
    postJson(route('auth.login'),  $data)->assertStatus(422);
});
