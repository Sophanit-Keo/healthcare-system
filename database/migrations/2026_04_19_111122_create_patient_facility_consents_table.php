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
        Schema::create('patient_facility_consents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();

            $table->enum('status', ['granted', 'revoked'])->default('granted');
            $table->json('scopes')->nullable();

            $table->timestamp('granted_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // If set, tracks who recorded this change (patient or staff/admin).
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['patient_id', 'facility_id']);
            $table->index(['facility_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_facility_consents');
    }
};
