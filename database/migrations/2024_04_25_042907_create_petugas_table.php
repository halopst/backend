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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->char('id_satker', length: 4)->nullable(false);
            $table->foreign('id_satker')->references('id_satker')->on('satkers')->onDelete('cascade');
            $table->string('nama_petugas')->nullable(false);
            $table->string('nama_panggilan')->nullable(true);
            $table->string('email_bps')->nullable(false);
            $table->string('email_google')->nullable(false);
            $table->string('nip_lama')->nullable(false);
            $table->string('no_hp')->nullable(false);
            $table->string('jabatan')->nullable(false);
            $table->boolean('tampil')->nullable(false);
            $table->string('status')->nullable(false);
            $table->string('foto')->nullable(true);
            $table->integer('hit')->nullable(true);
            $table->integer('jenis_kelamin')->nullable(true);
            $table->date('tanggal_diupdate')->nullable(true);
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
