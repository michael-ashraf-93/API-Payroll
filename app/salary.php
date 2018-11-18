<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    protected $fillable = [
        'month',
        'year',
        'salaries_payment_day',
        'bonus_payment_day',
        'salaries_total',
        'percentage',
        'bonus_total',
        'payments_total',
    ];
}
