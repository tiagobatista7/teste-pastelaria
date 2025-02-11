<?php

namespace Tests\Unit;

use App\Jobs\SendOrderEmailJob;
use App\Mail\OrderCreatedMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendOrderEmailJobTest extends TestCase
{
    use RefreshDatabase;

    public function send_email_after_creation_of_order()
    {
        Mail::fake();
        $customer = Customer::factory()->create([
            'email' => 'cliente@email.com'
        ]);

        $product = Product::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'email_sent_at' => null,
        ]);

        $order->products()->attach($product);
        $job = new SendOrderEmailJob($order);
        $job->handle();

        Mail::assertSent(OrderCreatedMail::class, function ($mail) use ($order) {
            return $mail->hasTo($order->customer->email) && $mail->order->id === $order->id;
        });
    }
}
