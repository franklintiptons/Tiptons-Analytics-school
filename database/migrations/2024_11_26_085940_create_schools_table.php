<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // School name
            $table->string('email')->unique();  // School email
            $table->string('phone')->nullable();  // School phone number
            $table->string('address')->nullable();  // School address
            $table->text('info')->nullable();  // School info (optional text)
            $table->string('logo')->nullable();  // Path to logo image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
}