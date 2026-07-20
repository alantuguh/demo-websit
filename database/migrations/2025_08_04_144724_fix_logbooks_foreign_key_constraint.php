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
        Schema::table('logbooks', function (Blueprint $table) {
            // Drop foreign key constraint lama yang mengarah ke teams
            $table->dropForeign(['asisten_id']);
            
            // Buat foreign key constraint baru yang mengarah ke users
            $table->foreign('asisten_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            // Drop foreign key constraint yang mengarah ke users
            $table->dropForeign(['asisten_id']);
            
            // Kembalikan foreign key constraint yang mengarah ke teams
            $table->foreign('asisten_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('set null');
        });
    }
};
