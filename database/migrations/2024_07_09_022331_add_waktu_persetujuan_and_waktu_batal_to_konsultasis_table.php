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
        Schema::table('konsultasis', function (Blueprint $table) {
            $table->datetime('waktu_persetujuan')->nullable(true)->after('waktu_pengajuan');
            $table->datetime('waktu_pembatalan')->nullable(true)->after('waktu_persetujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasis', function (Blueprint $table) {
            $table->dropColumn('waktu_pengajuan');
            $table->dropColumn('waktu_pembatalan');
        });
    }
};
