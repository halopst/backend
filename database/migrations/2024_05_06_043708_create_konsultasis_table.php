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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_konsultasi');
            $table->time('waktu_konsultasi');
            $table->string('link_meeting')->nullable(true);
            $table->text('topik_diskusi');
            $table->string('status');
            $table->string('link_bukti')->nullable(true);;
            $table->text('kritik_saran')->nullable(true);;
            $table->integer('rating')->nullable(true);;
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_petugas');
            $table->text('alasan_pembatalan')->nullable(true);
            $table->integer('id_petugas_batal')->nullable(true);
            $table->timestamps();
            $table->foreign('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('petugas')->onDelete('cascade');
            $table->integer('notif_flag')->nullable(false)->default(0)->change();
            $table->datetime('waktu_pengajuan')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
