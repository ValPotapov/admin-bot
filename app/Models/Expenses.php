<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "sum",
        "comment",
        "expenseTypeId",
        "contractorId"
    ];

    public function type(){
        return $this->belongsTo(ExpensesTypes::class,'expenseTypeId','id');
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class,'contractorId','id');
    }
}
