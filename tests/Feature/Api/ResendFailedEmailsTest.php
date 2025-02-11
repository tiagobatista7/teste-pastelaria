<?php

use App\Jobs\SendOrderEmailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;

uses(RefreshDatabase::class);

test('reenfila pedidos não confirmados por e-mail em 2 minutos', function () {
    Queue::fake();

    $customer = \App\Models\Customer::factory()->create();
    $product = \App\Models\Product::factory()->create();

    $order = \App\Models\Order::factory()->create([
        'customer_id' => $customer->id,
        'product_id' => $product->id,
        'email_sent_at' => null,
        'created_at' => now()->subMinutes(3),
    ]);
    $order->products()->attach($product);

    Carbon::setTestNow(now()->addMinutes(2));
    (new \App\Jobs\ResendFailedEmailsJob())->handle();
    Queue::assertPushed(SendOrderEmailJob::class, function ($job) use ($order) {
        return $job->order->id === $order->id;
    });
});
