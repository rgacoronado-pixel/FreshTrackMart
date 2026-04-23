<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\StockAlert;
use Illuminate\Support\Facades\Auth;

class InventoryObserver
{
    public function updating(Inventory $inventory)
    {
        $inventory->updated_by = Auth::id();

        $this->syncStockAlerts($inventory);
    }

    private function syncStockAlerts(Inventory $inventory): void
    {
        $stock = (int) $inventory->stock;
        $spoiled = (int) ($inventory->spoiled_stock ?? 0);
        $threshold = max((int) ($inventory->low_stock_threshold ?? 10), 1);
        $criticalThreshold = max((int) floor($threshold / 2), 1);
        $trackedTotal = max($stock + $spoiled, 1);
        $spoilageRate = ($spoiled / $trackedTotal) * 100;
        $highSpoilage = $spoiled >= max(5, $threshold) || $spoilageRate >= 30;

        $this->upsertAlert($inventory, 'low_stock', $threshold, $stock <= $threshold);
        $this->upsertAlert($inventory, 'critical_stock', $criticalThreshold, $stock <= $criticalThreshold);
        $this->upsertAlert($inventory, 'high_spoilage', $spoiled, $highSpoilage);
    }

    private function upsertAlert(Inventory $inventory, string $type, int $value, bool $active): void
    {
        if ($active) {
            StockAlert::updateOrCreate(
                [
                    'inventory_id' => $inventory->id,
                    'alert_type' => $type,
                    'resolved_at' => null,
                ],
                [
                    'threshold_value' => $value,
                    'triggered_at' => now(),
                    'notified_users' => [],
                ]
            );

            return;
        }

        StockAlert::query()
            ->where('inventory_id', $inventory->id)
            ->where('alert_type', $type)
            ->whereNull('resolved_at')
            ->update(['resolved_at' => now()]);
    }
}

