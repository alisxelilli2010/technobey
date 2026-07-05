<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Yeni sifariş — ' . $this->order->name,
            replyTo: $this->order->email
                ? [$this->order->email]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-order',
            with: ['order' => $this->order],
        );
    }
}
