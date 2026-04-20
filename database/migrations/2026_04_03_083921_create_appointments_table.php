<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    

    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('doctor')->nullable();
            $table->string('department');
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
