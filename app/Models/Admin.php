<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;

    // Add password to the fillable array
    protected $fillable = [
        'name',
        'email',
        'phone',
        'school_id',
        'password', // Added password to fillable fields
    ];

    /**
     * Relationship with School.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Automatically hash the password when it's set.
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($admin) {
            if ($admin->isDirty('password')) {
                $admin->password = Hash::make($admin->password); // Hash the password
            }
        });
    }
}
