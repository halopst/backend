<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Services\TwilioService;

class WhatsAppChannel
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            throw new \Exception('Notification does not have toWhatsApp method.');
        }

        $message = $notification->toWhatsApp($notifiable);

        $this->twilio->sendWhatsAppMessage($notifiable->routeNotificationForWhatsApp(), $message);
    }
}
