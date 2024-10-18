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
        //
        Schema::table('petugas_keahlians', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['petugas_id']);
            $table->dropForeign(['keahlians_id']);

            // Add foreign key constraints with onDelete cascade
            $table->foreign('petugas_id')->references('id')->on('petugas')->onDelete('cascade');
            $table->foreign('keahlians_id')->references('id')->on('keahlians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('petugas_keahlians', function (Blueprint $table) {
            // Drop the new foreign key constraints
            $table->dropForeign(['petugas_id']);
            $table->dropForeign(['keahlians_id']);

            // Add the original foreign key constraints without onDelete cascade
            $table->foreign('petugas_id')->references('id')->on('petugas');
            $table->foreign('keahlians_id')->references('id')->on('keahlians');
        });
    }
};
