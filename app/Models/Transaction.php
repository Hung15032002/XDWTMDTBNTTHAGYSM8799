<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_number',
        'transaction_date',
        'amount',
        'balance',
        'description',
    ];

    public $timestamps = true;
}
