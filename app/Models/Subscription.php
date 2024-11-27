<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'school_id',
        'package_id',
        'amount',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Define the relationship to the School model.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Define the relationship to the Package model (if exists).
     */
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * Accessor for active status.
     */
    public function getIsActiveLabelAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Check if the subscription is expired.
     */
    public function isExpired(): bool
    {
        return $this->end_date < now();
    }
}