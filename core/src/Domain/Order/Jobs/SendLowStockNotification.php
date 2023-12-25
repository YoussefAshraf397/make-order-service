<?php

namespace Domain\Order\Jobs;

use Domain\Models\Ingredient\Ingredient;
use Domain\Order\Mail\LowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Ingredient $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    public function handle(): void
    {
        Log::log('info', 'Sending email');
        Mail::to('merchant@example.com')->send(new LowStockNotification($this->ingredient));
    }
}
