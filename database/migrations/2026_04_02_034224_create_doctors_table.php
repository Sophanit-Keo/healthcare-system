<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('DoctorID');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('specialization');
            $table->enum('status', ['available', 'unavailable', 'onleave'])->default('onleave');
            $table->tinyInteger('years_of_experience')->unsigned();
            $table->decimal('consultation_fee', 10, 2);
            $table->tinyInteger('schedule_load')->unsigned();
            $table->text('biography_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
