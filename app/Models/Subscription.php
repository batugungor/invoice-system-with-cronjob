<?php

namespace App\Models;

use App\Enums\SubscriptionBillingCycle;
use App\Services\Subscription\CalculateDateBySubscriptionBillingCycle;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasUuids;

    protected $fillable = ["product_id", "user_id", "price", 'status', 'start_date', 'end_date', 'custom_billing_cycle', 'next_billing_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::created(function (Subscription $subscription) {
            $subscription->update([
                "next_billing_date" => CalculateDateBySubscriptionBillingCycle::calculate(
                    $subscription->start_date,
                    SubscriptionBillingCycle::from($subscription->billing_cycle)
                )
            ]);
        });
    }

    protected function billingCycle(): Attribute
    {
        $custom_billing_cycle = $this->product->billing_cycle;

        if (!is_null($this->custom_billing_cycle)) {
            $custom_billing_cycle = $this->custom_billing_cycle;
        }

        return Attribute::make(
            get: fn() => $custom_billing_cycle,
        );
    }
}
