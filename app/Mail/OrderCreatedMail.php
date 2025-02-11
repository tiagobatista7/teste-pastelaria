<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    /**
     * Criar uma nova instância da Mailable.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Construir a mensagem de e-mail.
     */
    public function build(): self
    {
        return $this->subject('Pedido Confirmado!')
            ->view('emails.order_created')
            ->with(['order' => $this->order]);
    }
}
