<?php

use App\Jobs\ResendFailedEmailsJob;
use App\Jobs\SendOrderEmailJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;

uses(RefreshDatabase::class);

test('reenfila pedidos não confirmados por e-mail em 2 minutos', function () {
    Queue::fake();

    // Criação do cliente e produto
    $customer = \App\Models\Customer::factory()->create();
    $product = \App\Models\Product::factory()->create();

    // Criação do pedido
    $order = \App\Models\Order::factory()->create([
        'customer_id' => $customer->id,
        'product_id' => $product->id,
        'email_sent_at' => null,
        'created_at' => now()->subMinutes(3),
    ]);
    $order->products()->attach($product);

    // Simulação da passagem de 2 minutos
    Carbon::setTestNow(now()->addMinutes(2));

    // Executando o job de reenvio de e-mail
    (new \App\Jobs\ResendFailedEmailsJob())->handle();

    // Verificando se o job foi enfileirado e se contém o ID do pedido correto
    Queue::assertPushed(SendOrderEmailJob::class, function ($job) use ($order) {
        // Verificando o ID do pedido diretamente do job enfileirado
        return $job->order->id === $order->id;
    });
});
