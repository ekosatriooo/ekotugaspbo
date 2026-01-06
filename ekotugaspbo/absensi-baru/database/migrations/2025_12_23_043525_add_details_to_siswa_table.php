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
        Schema::table('siswa', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->after('nama')->nullable();
            $table->string('no_hp')->after('kelas')->nullable();
            $table->text('alamat')->after('no_hp')->nullable();
            $table->date('tanggal_lahir')->after('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            //
        });
    }
};
