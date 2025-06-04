<?php

namespace App\Enums;

enum SubscriptionBillingCycle: string
{
    case Weekly = "weekly";
    case Biweekly = "biweekly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case Yearly = "yearly";
}
