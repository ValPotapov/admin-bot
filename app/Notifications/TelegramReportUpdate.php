<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramReportUpdate extends Notification
{
    use Queueable;
    protected $reportText = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reportText)
    {
        $this->reportText = $reportText;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($report)
    {
        return TelegramMessage::create()
            ->to($report->routes['telegram-bot-api'])
            ->content($this->reportText);
    }
}
