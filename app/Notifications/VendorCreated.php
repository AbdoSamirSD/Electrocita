<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $vendor;
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Your Store Created Successfully')
        ->greeting('Hello!')
        ->line('A new vendor has been created.')
        ->line('Vendor Name: ' . $this->vendor->name)
        ->line('Vendor Email: ' . $this->vendor->email)
        ->line('Vendor Phone: ' . $this->vendor->phone)
        ->line('Vendor Address: ' . $this->vendor->address)
        ->action('View Vendor', '')
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
