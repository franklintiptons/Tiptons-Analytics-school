<?php

// In the migration file: database/migrations/xxxx_xx_xx_xxxxxx_create_packages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name of the package
            $table->text('description')->nullable(); // Description of the package
            $table->decimal('price', 8, 2); // Price of the package
            $table->enum('interval', ['monthly', 'yearly']); // Payment interval (monthly or yearly)
            $table->integer('period'); // Duration in months (e.g., 1, 6, 12 months)
            $table->integer('student_limit')->default(0); // Limit for the number of students
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
}