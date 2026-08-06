<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
      'path',
      'alt',
      'product_id',
    ];

    public function product(): BelongsTo {
      return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
