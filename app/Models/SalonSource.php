<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'salon_id'
    ];
}
