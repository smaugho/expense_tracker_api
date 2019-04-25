<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expense';

    protected $fillable = [
        'description', 'amount', 'date', 'time', 'comment', 'number', 'user_id'
    ];

    protected $casts = [
        'date' => 'datetime:d/m/Y',
    ];

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value);
        return $date->format('d/m/Y');
    }

    public function getTimeAttribute($value)
    {
        $time = Carbon::createFromFormat('H:i:s', $value);
        return $time->format('h:i a');
    }

    public function getAmountAttribute($value)
    {
        return '$' . $value;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
