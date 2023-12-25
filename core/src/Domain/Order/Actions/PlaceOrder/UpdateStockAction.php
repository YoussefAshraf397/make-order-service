<?php

namespace Domain\Order\Actions\PlaceOrder;

use App\BaseApp\Enums\UnitEnums;
use Domain\Models\Ingredient\Ingredient;
use Domain\Order\Jobs\SendLowStockNotification;
use Illuminate\Database\Eloquent\Model;

class UpdateStockAction
{
    public function __invoke(Model $product, float $quantity): void
    {
        foreach ($product->ingredients as $ingredient) {
            $this->updateIngredientStock($ingredient, $quantity);
        }
    }

    private function updateIngredientStock(Ingredient $ingredient, $quantity): void
    {
        $gramsConsumed = $ingredient->pivot->quantity * $quantity;

        if ($ingredient->unit === UnitEnums::KILO_GRAM) {
            $gramsConsumed /=  1000;
        }

        $this->lockForUpdate($ingredient);

        $ingredient->update([
            'stock_quantity' => $ingredient->stock_quantity - $gramsConsumed
        ]);

        $this->checkAndSendLowStockNotification($ingredient);
    }

    private function lockForUpdate(Ingredient $ingredient): void
    {
        // Lock the row for update to prevent concurrency issues
        $ingredient->lockForUpdate()->first();
    }

    private function checkAndSendLowStockNotification(Ingredient $ingredient): void
    {
        // Check if stock is below 50% and send an email
        if ($ingredient->initial_stock * 0.5 > $ingredient->stock_quantity && !$ingredient->email_sent) {
            $this->sendEmail($ingredient);
            $ingredient->email_sent = true;
            $ingredient->save();
        }
    }

    private function sendEmail(Ingredient $ingredient): void
    {
        dispatch(new SendLowStockNotification($ingredient))->onQueue('foodics_queue');
    }
}
