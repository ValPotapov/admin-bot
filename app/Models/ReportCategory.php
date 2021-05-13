<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
    use HasFactory;

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'reports_categories');
    }
}
