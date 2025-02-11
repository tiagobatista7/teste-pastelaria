<?php

test('list all customers', function () {
    \App\Models\Customer::factory()->count(3)->create();

    $response = $this->getJson('/customers');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

test('create a client', function () {
    $data = \App\Models\Customer::factory()->make()->toArray();

    $response = $this->postJson('/customers', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['email' => $data['email']]);

    $this->assertDatabaseHas('customers', ['email' => $data['email']]);
});

test('update a client', function () {
    $customer = \App\Models\Customer::factory()->create();
    $newData = \App\Models\Customer::factory()->make()->toArray();
    $newData['name'] = 'Updated Name';

    $response = $this->putJson("/customers/{$customer->id}", $newData);


    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Updated Name']);

    $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Updated Name']);
});

test('delete a customer', function () {
    $customer = \App\Models\Customer::factory()->create();

    $response = $this->deleteJson("/customers/{$customer->id}");

    $response->assertStatus(204);
    $this->assertSoftDeleted('customers', ['id' => $customer->id]);
});
