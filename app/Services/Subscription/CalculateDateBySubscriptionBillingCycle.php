<?php

namespace App\Services\Subscription;

use App\Enums\SubscriptionBillingCycle;
use DateTime;

class CalculateDateBySubscriptionBillingCycle
{
    public static function calculate(DateTime $date, SubscriptionBillingCycle $billingCycle): DateTime
    {
        switch ($billingCycle) {
            case SubscriptionBillingCycle::Weekly:
                $date->modify('+1 week');
                break;

            case SubscriptionBillingCycle::Biweekly:
                $date->modify('+2 week');
                break;

            case SubscriptionBillingCycle::Monthly:
                $date->modify('+1 month');
                break;

            case SubscriptionBillingCycle::Quarterly:
                $date->modify('+3 month');
                break;

            case SubscriptionBillingCycle::Yearly:
                $date->modify('+1 year');
                break;
        }

        return $date;
    }
}
