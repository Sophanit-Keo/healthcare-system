<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    

    public function up(): void
    {
        Schema::create('health_staff', function (Blueprint $table) {
            $table->id();

            $table->string('staff_code', 20)->unique();

            $table->foreignId('facility_id')
                ->constrained('facilities')
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('role', 30);
            $table->string('license_number', 50)->nullable();
            $table->date('hire_date')->nullable();
            $table->string('status', 20)->default('active');

            $table->timestamps();
        });
    }

    

    public function down(): void
    {
        Schema::dropIfExists('health_staff');
    }
};
