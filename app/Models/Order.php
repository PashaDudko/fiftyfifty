<?php

namespace App\Models;

use App\Enums\Order as OrderEnum;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
        'title',
        'description',
        'current_amount',
        'free_shipping_threshold',
        'join_deadline_at',
        'status',
    ];

    protected $casts = [
        'status' => OrderEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
