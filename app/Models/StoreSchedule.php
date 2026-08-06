<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends Model
{
    protected $fillable = [
      'open_time',
      'close_time',
      'day_of_week',
      'is_closed',
      'specific_date'
    ];
}
