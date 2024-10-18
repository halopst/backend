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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengguna');
            $table->string('email_google');
            $table->string('family_name');
            $table->string('given_name');
            $table->string('status');
            $table->string('foto')->nullable(true);
            $table->string('pekerjaan')->nullable(true);
            $table->string('jenis_kelamin')->nullable(true);
            $table->date('tanggal_lahir')->nullable(true);
            $table->char('id_prov', length: 2)->nullable(true);
            $table->char('id_kab', length: 4)->nullable(true);
            $table->string('nmr_telp')->nullable(true);
            $table->string('pendidikan')->nullable(true);
            $table->timestamps();
            
            $table->foreign('id_prov')->references('id_prov')->on('provinsis')->onDelete('cascade');
            $table->foreign('id_kab')->references('id_kab')->on('kabupatens')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
