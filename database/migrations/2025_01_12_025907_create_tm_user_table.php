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
        Schema::create('tm_user', function (Blueprint $table) {
            $table->string('user_id', 10)->primary();
            $table->string('user_nama', 50);
            $table->string('user_pass', 255); // Gunakan bcrypt, bukan MD5
            $table->enum('user_hak', ['su', 'admin', 'operator']);
            $table->enum('user_sts', ['0', '1'])->default('1'); // Default aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_user');
    }
};
