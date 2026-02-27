<?php

namespace App\Actions;

use App\Models\Order;

class AttachUserToOrderAction
{
    public function attach(Order $order, int $userId, int $amount): void
    {
        $order->subscribers()->attach($userId, ['amount' => $amount]);
    }
}
