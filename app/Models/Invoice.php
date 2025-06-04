<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasUuids;

    protected $fillable = ['subscription_id', 'user_id', 'due_date', 'paid_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceLineItems()
    {
        return $this->hasMany(InvoiceLineItem::class);
    }
}
