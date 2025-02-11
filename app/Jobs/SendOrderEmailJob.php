<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    public int $tries = 3; // Tentar 3 vezes antes de falhar

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function handle()
    {
        $order = Order::with('products', 'customer')->find($this->order->id);

        if (!$order) {
            return;
        }

        Mail::to($order->customer->email)->send(new OrderCreatedMail($order));
    }
}
