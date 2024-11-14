<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use function Illuminate\Events\queueable;


class Billable extends Model
{
/**
 * The "booted" method of the model.
 */
    protected static function booted(): void {
        static::updated(queueable(function (User $customer) {
        if ($customer->hasStripeId()) {
            $customer->syncStripeCustomerDetails();
        }
    }));
}
}
