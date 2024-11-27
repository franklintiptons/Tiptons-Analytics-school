<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pending_requests', function (Blueprint $table) {
            // Change the 'status' column to ENUM type with possible values
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'inactive'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_requests', function (Blueprint $table) {
            // Rollback the change by resetting the 'status' column
            $table->string('status')->change();
        });
    }
};