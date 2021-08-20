<?php

namespace App\Notifications;

use App\Reports\DailyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\View\View;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramReport extends Notification
{
    use Queueable;

    protected $reportData = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return [TelegramChannel::class];
    }


    public function toTelegram($report)
    {
        switch ($this->reportData->getType()){
            case "link":
                return TelegramMessage::create()
                    ->to($report->routes['telegram-bot-api'])
                    ->content('Сгенерирован отчет "'.$this->reportData->getTitle().'"')
                    ->button('Просмотреть отчет',env('APP_URL').$this->reportData->getData());
                break;
            case "view":
                return TelegramMessage::create()
                    ->to($report->routes['telegram-bot-api'])
                    ->view('reports.telegramReport', ['reportData'=> $this->reportData->getData()]);
                break;
            default:
                return TelegramMessage::create()
                    ->to($report->routes['telegram-bot-api'])
                    ->content($this->reportData->getData());
        }


    }
}
