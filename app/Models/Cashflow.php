<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cashflow extends Model
{
    protected $fillable = [
      'in_out',
      'amount',
      'description',
      'transaction_type'
    ];

    public function user_cashflow(): hasMany {
      return $this->hasMany(User_Cashflow::class, 'cashflow_id');
    }
}
