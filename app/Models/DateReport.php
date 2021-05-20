<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'salon_id',
        'fixed'
    ];

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
