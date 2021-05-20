<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonSourceValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'source_id',
        'value'
    ];
}
