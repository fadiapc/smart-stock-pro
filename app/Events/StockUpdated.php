<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $productId,
        public int $newStock,
        public int $quantitySold,
        public string $productName
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('inventory-channel');
    }

    public function broadcastAs(): string
    {
        return 'StockUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'new_stock' => $this->newStock,
            'sold_quantity' => $this->quantitySold,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
