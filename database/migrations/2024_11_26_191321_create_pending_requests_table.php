<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('pending_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade'); // Foreign key for school_id
            $table->decimal('price', 10, 2); // Price for the request
            $table->string('payment_for'); // Payment For (e.g., subscription, service, etc.)
            $table->string('payment_document')->nullable(); // Payment Document (file path or URL)
            $table->enum('status', ['pending', 'approved', 'suspended'])->default('pending'); // Status of the request
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_requests');
    }
}