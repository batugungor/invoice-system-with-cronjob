<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'default_price', 'billing_cycle'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
