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
        'phone',
        'came',
        'stayed'
    ];

    public function categories()
    {
        return $this->belongsToMany(ReportCategory::class, 'reports_categories');
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
}
