<?php

namespace Domain\Order\Mail;

use Domain\Models\Ingredient\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Ingredient $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    public function build(): LowStockNotification
    {
        return $this->subject('Low Stock Alert')->view('emails.low_stock_notification', [
            'ingredient' => $this->ingredient
        ]);
    }
}
