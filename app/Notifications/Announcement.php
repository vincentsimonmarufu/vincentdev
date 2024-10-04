<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Announcement extends Notification
{
    use Queueable;
    protected $subject, $introduction, $url_text, $url, $conclusion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $introduction, $url_text, $url, $conclusion)
    {
        $this->subject = $subject;
        $this->introduction = $introduction;
        $this->url_text = $url_text;
        $this->url = $url;
        $this->conclusion = $conclusion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject($this->subject)
            ->line($this->introduction)
            ->action($this->url_text, url($this->url))
            ->line($this->conclusion);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
