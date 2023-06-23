<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ToAgantIsNewOrganizationBinding extends Notification
{
    use Queueable;

    protected $subject;
    protected $new_password;

    public function __construct($subject='',  $msg='')
    {
        $this->subject = $subject;
        $this->msg = $msg;
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
                    ->subject($this->subject)
                    ->view('emails.to_agent_is_organization_binding', ['msg' => $this->msg, 'user' => $notifiable])
                    ->from(config('constants.email.noreply'));
    }

}
