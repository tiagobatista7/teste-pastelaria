<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResendFailedEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Buscar pedidos sem e-mail enviado nos últimos 2 minutos
        $orders = Order::whereNull('email_sent_at')
            ->where('created_at', '<=', now()->subMinutes(2))
            ->get();

        foreach ($orders as $order) {
            dispatch(new SendOrderEmailJob($order))->delay(now()->addSeconds(10));
        }
    }
}
