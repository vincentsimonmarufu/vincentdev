<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserMail extends Notification
{
    use Queueable;
    private $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
        //return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('noreply@abisiniya.com', 'Abisiniya')
            ->replyTo('info@abisiniya.com', 'Information Desk')
            ->subject($this->details['subject'])
            ->line($this->details['message'])
            ->action('VIEW', $this->details['actionURL'])
            ->line('Thank you for using Abisiniya!');
    }


    public function toArray($notifiable)
    {

        return [
            'subject' => $this->details['subject'],
            'message' => $this->details['message'],
            'url' => $this->details['actionURL'],

        ];
    }
}
