<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre commande ' . ($this->order->order_number ?? '#' . $this->order->id) . ' est prête ! — ISI BURGER',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-ready',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $path = 'public/invoices/' . $this->order->invoice_number . '.pdf';

        if ($this->order->invoice_number && Storage::exists($path)) {
            return [
                Attachment::fromStorage($path)
                    ->as('Facture-' . $this->order->invoice_number . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
