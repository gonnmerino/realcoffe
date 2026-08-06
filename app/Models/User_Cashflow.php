<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Cashflow extends Model
{
  protected $fillable = [
    'cashflow_id',
    'user_id',
  ];

  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function cashflow() {
    return $this->belongsTo(Cashflow::class, 'cashflow_id');
  }
}
