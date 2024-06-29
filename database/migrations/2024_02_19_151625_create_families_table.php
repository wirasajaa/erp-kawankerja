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
        Schema::create('families', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->char('identity_number', 20)->unique();
            $table->string('name');
            $table->enum('relationship', ['FATHER', 'MOTHER', 'SISTER', 'BROTHER']);
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('birthday');
            $table->string('birthplace');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
