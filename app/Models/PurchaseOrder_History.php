<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder_History extends Model
{
    //
  protected $fillable = [
    'order_status',
    'notes',
    'purchase_order_id',
    'user_id',
  ];
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function purchaseOrder(): belongsTo {
    return $this->belongsTo(PurchaseOrder::class);
  }
}
