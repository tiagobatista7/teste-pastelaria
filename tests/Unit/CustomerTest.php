<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Http\Controllers\Api\CustomerController as ApiCustomerController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;


class CustomerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Artisan::call('migrate');
    }

    protected function setUpDatabaseConfig(): void
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
    }

    public function test_list_all_clients(): void
    {
        $customers = Customer::factory()->count(3)->make();

        $controller = Mockery::mock(ApiCustomerController::class);
        $controller->shouldReceive('index')
            ->once()
            ->andReturn(new JsonResponse($customers));

        $response = $controller->index();
        $this->assertCount(3, $response->getData());
    }

    public function test_create_a_client(): void
    {
        $data = Customer::factory()->make()->toArray();
        $mock = Mockery::mock(Customer::class)->makePartial();
        $mock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Customer($data));
        $customer = $mock->create($data);
        $this->assertEquals($data['email'], $customer->email);
    }

    public function test_update_a_cliente_with_repository()
    {
        $customer = Customer::factory()->create();
        $newData = [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
        ];

        $response = $this->putJson(route('customers.update', $customer->id), $newData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_exclui_um_cliente(): void
    {
        $customer = Customer::factory()->create();

        $repositoryMock = Mockery::mock(CustomerRepository::class);

        $repositoryMock->shouldReceive('delete')
            ->once()
            ->with($customer->id)
            ->andReturn(true);

        $response = $repositoryMock->delete($customer->id);
        $this->assertTrue($response);

        $repositoryMock->shouldHaveReceived('delete')
            ->once()
            ->with($customer->id);
    }
}
