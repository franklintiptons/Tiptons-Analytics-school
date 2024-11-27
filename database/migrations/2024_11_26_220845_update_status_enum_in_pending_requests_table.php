<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateStatusEnumInPendingRequestsTable extends Migration
{
    public function up()
    {
        // First, update all rows where 'status' is not part of the new ENUM options
        DB::statement("UPDATE pending_requests SET status = 'pending' WHERE status NOT IN ('pending', 'approved', 'suspended', 'rejected')");

        // Alter the status column to add 'rejected' to the ENUM
        DB::statement("ALTER TABLE pending_requests MODIFY COLUMN status ENUM('pending', 'approved', 'suspended', 'rejected') NOT NULL;");
    }

    public function down()
    {
        // Revert the status column to the previous ENUM values (without 'rejected')
        DB::statement("ALTER TABLE pending_requests MODIFY COLUMN status ENUM('pending', 'approved', 'suspended') NOT NULL;");
    }
}