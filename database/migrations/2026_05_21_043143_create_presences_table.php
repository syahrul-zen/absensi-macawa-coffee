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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggal');

            $table->time('jam_masuk_asli')->nullable();
            $table->string('latitude_masuk')->nullable();
            $table->string('longitude_masuk')->nullable();
            $table->integer('jarak_masuk_meter')->nullable();

            $table->time('jam_pulang_asli')->nullable();
            $table->string('latitude_pulang')->nullable();
            $table->string('longitude_pulang')->nullable();
            $table->integer('jarak_pulang_meter')->nullable();

            // Status Presensi
            $table->enum('status', ['Tepat Waktu', 'Terlambat', 'Alpa', 'Izin'])->default('Alpa');
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
