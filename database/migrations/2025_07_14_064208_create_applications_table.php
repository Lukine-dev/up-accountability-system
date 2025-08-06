<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->timestamp('application_date')->nullable();

            // Add status and returned_at columns
            $table->enum('status', ['active', 'returned',])->default('active');
            $table->timestamp('returned_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('applications');
        Schema::enableForeignKeyConstraints();
    }
};
