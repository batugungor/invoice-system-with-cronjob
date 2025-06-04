<?php

namespace App\Services\DiscordWebhooks;

use App\Models\Invoice;

class InvoiceWebhooks
{
    public static function InvoiceReminder(Invoice $invoice): array
    {
        return [
            "username" => "Facturatie",
            "content" => "Er is een nieuwe factuur aangemaakt voor {$invoice->user->email} voor € {$invoice->total}",
            "embeds" => [
                [
                    "fields" => [
                        [
                            "name" => "",
                            "value" => "[Factuur inzien](https://google.com)",
                            "inline" => true
                        ],
                        [
                            "name" => "",
                            "value" => "[Markeren als betaald](https://google.com)",
                            "inline" => true
                        ],
                    ]
                ]
            ]
        ];
    }
}
