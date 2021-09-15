<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class DateReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'salon_id',
        'fixed'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($reportDate) {
            foreach (config('reports.daily_report.to') as $to) {
                Notification::route('telegram-bot-api', $to)->notify(new \App\Notifications\TelegramReportUpdate('Отчет ' . $reportDate->salon->name . ' ' . $reportDate->date . ' заполнен'));
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
}
