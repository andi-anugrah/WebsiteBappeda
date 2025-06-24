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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('judul_dokumen');
            $table->enum('kategori', [
                'rpjmd',
                'rpjpd', 
                'rkpd',
                'renja',
                'renstra',
                'dokumen_lainnya'
            ]);
            $table->string('file_dokumen')->nullable(); // path to uploaded file
            $table->string('original_filename')->nullable(); // original filename
            $table->string('file_size')->nullable(); // file size in bytes
            $table->string('file_type')->nullable(); // mime type
            $table->year('tahun')->nullable();
            $table->timestamps();
            
            $table->index(['kategori', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};