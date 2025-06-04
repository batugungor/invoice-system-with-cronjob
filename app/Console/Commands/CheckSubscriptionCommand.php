<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\Subscription;
use App\Services\DiscordWebhooks\InvoiceWebhooks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "subscription:check";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check all subscriptions and create invoices";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();
        $week_from_today = $today->copy()->addWeek();
        $from = $week_from_today->copy()->startOfDay();
        $to = $week_from_today->copy()->endOfDay();


        // I KNOW THIS IS NOT HOW IT'S SUPPOSED TO BE BUTY I WAS TOO LAZY PLUS ITS A TEST PROJECT!!! NEXT TIME I'LL ADD IT INTO ENV!!
        Http::post('https://discord.com/api/webhooks/1337129298926108712/6cG75iAcT5f4NJTXmE-eTd43Kpsk6RQjbMwvLyooq6-sodyoeazpIhCtQqgHPcBK3LsR',
            [
                "username" => "Cronjob test",
                "content" => "Dit is een cronjob test",
            ]
        );

        $subscriptions = Subscription::whereBetween('next_billing_date', [$from, $to])
            ->with(['product'])
            ->get()
            ->groupBy('user_id');

        foreach ($subscriptions as $userId => $userSubscriptions) {
            $invoice = Invoice::firstOrCreate([
                'user_id' => $userId,
                'due_date' => $week_from_today->endOfDay(),
            ], [
                'status' => InvoiceStatus::Pending,
            ]);

            foreach ($userSubscriptions as $subscription) {
                InvoiceLineItem::firstOrCreate([
                    'invoice_id' => $invoice->id,
                    'subscription_id' => $subscription->id,
                ], [
                    'description' => $subscription->description,
                    'amount' => 1,
                    'unit_price' => $subscription->price,
                    'total_price' => $subscription->price,
                ]);
            }

            $invoice->total = $invoice->invoiceLineItems->sum('total_price');
            $invoice->save();

            if ($invoice->wasRecentlyCreated) {

                // I KNOW THIS IS NOT HOW IT'S SUPPOSED TO BE BUTY I WAS TOO LAZY PLUS ITS A TEST PROJECT!!! NEXT TIME I'LL ADD IT INTO ENV!!
                Http::post('https://discord.com/api/webhooks/1337129298926108712/6cG75iAcT5f4NJTXmE-eTd43Kpsk6RQjbMwvLyooq6-sodyoeazpIhCtQqgHPcBK3LsR',
                    InvoiceWebhooks::InvoiceReminder($invoice)
                );
            }
        }
    }
}
