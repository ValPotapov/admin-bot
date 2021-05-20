<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'number_calls',
        'came',
        'stayed',
        'sum',
        'date',
        'cause',
        'source_value',
        'source_id',
        'date_report_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(ReportCategory::class, 'reports_categories');
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeReport::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
