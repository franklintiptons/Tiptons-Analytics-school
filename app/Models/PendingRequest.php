<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingRequest extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        'school_id',
        'price',
        'payment_for',
        'payment_document',
        'status'
    ];

    /**
     * Define the relationship with the School model.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Accessor for displaying the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'suspended' => 'Suspended',
            'rejected' => 'Rejected'
        ];

        return $statusLabels[$this->status] ?? 'Unknown';
    }

    /**
     * Scope to filter pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to filter approved requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to filter suspended requests.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope to filter rejected requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if the request is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the request is suspended.
     */
    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if the request is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Approve the pending request.
     */
    public function approve()
    {
        $this->status = 'approved';
        $this->save();
    }

    /**
     * Reject the pending request.
     */
    public function reject()
    {
        $this->status = 'rejected';
        $this->save();
    }

    /**
     * Suspend the pending request.
     */
    public function suspend()
    {
        $this->status = 'suspended';
        $this->save();
    }
}