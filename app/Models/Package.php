<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',           // Package name
        'description',    // Package description
        'price',          // Price of the package
        'interval',       // Billing interval (e.g., monthly, yearly)
        'period',         // Period in units (e.g., 1 for 1 month, 12 for 1 year)
        'student_limit',  // Maximum number of students allowed
    ];

    /**
     * The subscriptions associated with the package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Accessor for formatted price with currency.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2); // Adjust the currency as needed
    }

    /**
     * Accessor for human-readable billing period.
     *
     * @return string
     */
    public function getBillingPeriodAttribute(): string
    {
        return "{$this->period} {$this->interval}" . ($this->period > 1 ? 's' : '');
    }
}