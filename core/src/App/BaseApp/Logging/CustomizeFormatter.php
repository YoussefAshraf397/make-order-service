<?php

namespace App\BaseApp\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SlackWebhookHandler;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param Logger $logger
     * @return void
     */
    public function __invoke(Logger $logger): void
    {
        $dateFormat = "Y-m-d H:i:s";
        $checkLocal = env('APP_ENV');

        foreach ($logger->getHandlers() as $handler) {
            if ($handler instanceof SlackWebhookHandler) {
                $output = "[$checkLocal]: %datetime% > %level_name% - %message% `%context% %extra%` :poop: \n";
                $formatter = new LineFormatter($output, $dateFormat);

                $handler->setFormatter($formatter);
                $handler->pushProcessor(
                    function ($record) {
                        $record['extra']['ip'] = request()->getClientIp();
                        $record['extra']['method'] = request()->method();
                        $record['extra']['path'] = request()->fullUrl();
                        $record['extra']['headers'] = request()->header();
                        $record['extra']['input'] = request()->all();

                        if (isset($record['context']['exception'])) {
                            $record['message'] = (string)$record['context']['exception'];
                        }

                        return $record;
                    }
                );
            }
        }
    }
}
