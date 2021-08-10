<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send {reportType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reports based on /config/reports.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reportType = $this->argument('reportType');
        if($reportType) {
            $reportConfig = config('reports.'.$reportType);
            try {
                $className = '\App\Reports\\' . $reportConfig['data_class'];
                $reportClass = new $className($reportConfig['data_params']);

                if($reportClass->getData()) {
                    if (is_array($reportConfig['to'])) {
                        foreach ($reportConfig['to'] as $recipient) {
                            Notification::route('telegram-bot-api', $recipient)->notify(new \App\Notifications\TelegramReport($reportClass));
                        }
                    } else {
                        Notification::route('telegram-bot-api', $reportConfig['to'])->notify(new \App\Notifications\TelegramReport($reportClass));
                    }
                }else{
                    return 0;
                }
            } catch (Exception $exception) {
                return 0;
            }
            return true;
        }else{
            return 0;
        }
    }
}
