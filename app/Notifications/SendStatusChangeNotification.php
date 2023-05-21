<?php

namespace App\Notifications;

use App\Events\NotifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SocketChannel;

class SendStatusChangeNotification extends Notification
{
    use Queueable;

    private $message;
    private $user;
    private $deal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $user, $deal)
    {
        $this->message = $message;
        $this->user = $user;
        $this->deal = $deal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SocketChannel::class];
    }

    public function toSocket()
    {
        broadcast(new NotifyUser($this->message, $this->user, $this->deal));
    }

}
