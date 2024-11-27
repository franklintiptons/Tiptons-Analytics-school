<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // Foreign key linking to the schools table
            $table->foreignId('school_id')
                ->constrained('schools')
                ->cascadeOnDelete()
                ->comment('Foreign key linking to the schools table');

            // Foreign key linking to the packages table
            $table->foreignId('package_id')
                ->constrained('packages')
                ->cascadeOnDelete()
                ->comment('Foreign key linking to the packages table');

            $table->decimal('amount', 10, 2)
                ->comment('Amount charged for the subscription');

            $table->date('start_date')
                ->comment('Subscription start date');

            $table->date('end_date')
                ->comment('Subscription end date');

            $table->boolean('is_active')
                ->default(true)
                ->comment('Indicates if the subscription is active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
}