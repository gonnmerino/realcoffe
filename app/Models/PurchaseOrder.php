<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
  protected $fillable = [
    'pickup_code',
    'total_price',
    'user_id',
    'notes',
  ];

  public function product_purchase_order(): HasMany
  {
    return $this->hasMany(Product_PurchaseOrder::class, 'purchase_order_id');
  }
  public function latestHistory()
  {
    return $this->hasOne(PurchaseOrder_History::class, 'purchase_order_id')->latestOfMany();
  }
  public function purchase_order_history(): hasMany
  {
    return $this->hasMany(PurchaseOrder_History::class, 'purchase_order_id')->orderBy('created_at', 'asc');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
