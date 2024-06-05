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
        Schema::create('employees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('ktp_number', 20)->unique();
            $table->string('nip')->unique()->nullable();
            $table->string('fullname');
            $table->string('nickname');
            $table->string('title_front')->nullable();
            $table->string('title_back')->nullable();
            $table->char('whatsapp_number', 20)->unique();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->enum('religion', ['ISLAM', 'KRISTEN', 'KHATOLIK', 'HINDU', 'BUDDHA', 'KONGHUCU']);
            $table->enum('marital_status', ['MENIKAH', 'LAJANG', 'CERAI_HIDUP', 'CERAI_MATI'])->default('LAJANG');
            $table->date('birthday');
            $table->string('birthplace');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O']);
            $table->foreignUlid('created_by')->nullable()->constrained('users');
            $table->foreignUlid('updated_by')->nullable()->constrained('users');
            $table->foreignUlid('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
