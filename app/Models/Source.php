<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'for_all',
    ];

    public function salons()
    {
        return $this->belongsToMany(Salon::class, 'salon_sources');
    }
}
