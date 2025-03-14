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
        Schema::create('keahlians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_keahlian')->nullable(false);
            $table->string('icon')->nullable(false);
            $table->integer('tampilkan')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keahlians');
    }
};
