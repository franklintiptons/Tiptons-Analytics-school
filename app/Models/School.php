<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    // List of fillable attributes
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'image',
        'status',
    ];

    /**
     * Relationship with Admins.
     * A School can have many Admins.
     */
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Add additional methods for potential future functionality (e.g., soft deletes, etc.)
     */

    // Optionally, you can add soft deletes if the schools should not be fully deleted.
    // use Illuminate\Database\Eloquent\SoftDeletes;
    // protected $dates = ['deleted_at'];

    // Method to get the active status of the school
    public function getStatusAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }

    // You can add any additional custom methods for your school model here, if needed.
}