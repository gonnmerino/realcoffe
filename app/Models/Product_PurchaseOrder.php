<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product_PurchaseOrder extends Model
{
    protected $fillable = [
      'product_id',
      'purchase_order_id',
      'price',
      'quantity',
    ];

  public function product(): BelongsTo {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function purchaseOrder(): BelongsTo {
    return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
  }
}
