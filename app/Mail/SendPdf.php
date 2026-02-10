<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendPdf extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        //

        $this->order = $order->load('order_items.paper');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Pdf',
            from: new Address('protrixxlearnke@gmail.com', config('app.name')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
{
    $attachments = [];

    // Match the relationship name here too
    foreach ($this->order->order_items as $item) {
        $paper = $item->paper;

        if (!$item->paper) {
        Log::error("OrderItem ID {$item->id} is missing its Paper relationship!");
    }

        if ($paper && $paper->file_path) {
            $attachments[] = Attachment::fromStorageDisk('spaces',  $paper->file_path)
                ->as($paper->title . '.pdf')
                ->withMime('application/pdf');;
              
        }
    }

    return $attachments;
}
}
