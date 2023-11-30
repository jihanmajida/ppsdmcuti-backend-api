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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('dokumen_id')->unsigned();
            $table->string('NIP');
            $table->string('Nama');
            $table->enum('Divisi', ['Fungsional Widyaiswara', 
                        'Bagian Tata Usaha', 'Sub-Bagian Perencanaan',
                        'Sub-bagian Administrasi dan Kepegawaian', 'Sub-Bagian Rumah Tangga dan Sarana Pra Sarana',
                        'Bidang Pengembangan Kompetensi Jabatan Pimpinan Tinggi Pratama, Administrator dan Pengawas',
                        'Seksi Kompetensi jabatan Pimpinan TInggi Pratama',
                        'Seksi Kompetensi Administrator', 'Seksi Kompetensi Pengawas',
                        'Seksi Kompetensi Jabatan Fungsional', 'Seksi Kompetensi Pelaksana',
                        'Seksi Kompetensi Kepala Daerah, Wakil KEpala Daerah, DPR, dan Lurah']);
            $table->string('foto_profil');
            $table->integer('sisa_cuti');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('dokumen_id')->references('id')->on('dokumens')->onUpdate('cascade')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
