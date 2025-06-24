<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_dokumen',
        'kategori',
        'file_dokumen',
        'original_filename',
        'file_size',
        'file_type',
        'tahun'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'file_size' => 'integer'
    ];

    public static function getKategoriOptions(): array
    {
        return [
            'rpjmd' => 'RPJMD',
            'rpjpd' => 'RPJPD',
            'rkpd' => 'RKPD',
            'renja' => 'RENJA',
            'renstra' => 'RENSTRA',
            'dokumen_lainnya' => 'Dokumen Lainnya',
        ];
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::getKategoriOptions()[$this->kategori] ?? $this->kategori;
    }

    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_dokumen) {
            return null;
        }

        return Storage::disk('public')->url($this->file_dokumen);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return '-';
        }

        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getFileExtensionAttribute(): ?string
    {
        if (!$this->original_filename) {
            return null;
        }

        return strtoupper(pathinfo($this->original_filename, PATHINFO_EXTENSION));
    }

    public function getFileIconAttribute(): string
    {
        $extension = $this->file_extension;
        
        return match($extension) {
            'PDF' => 'fas fa-file-pdf text-danger',
            'DOC', 'DOCX' => 'fas fa-file-word text-primary',
            'XLS', 'XLSX' => 'fas fa-file-excel text-success',
            'PPT', 'PPTX' => 'fas fa-file-powerpoint text-warning',
            default => 'fas fa-file text-secondary'
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        if ($kategori && $kategori !== 'all') {
            return $query->where('kategori', $kategori);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('judul_dokumen', 'like', '%' . $search . '%')
                  ->orWhere('original_filename', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    public function scopeByYear($query, $year)
    {
        if ($year) {
            return $query->where('tahun', $year);
        }
        return $query;
    }

    // Boot method to handle file deletion
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            if ($document->file_dokumen && Storage::disk('public')->exists($document->file_dokumen)) {
                Storage::disk('public')->delete($document->file_dokumen);
            }
        });
    }

    // Additional helper methods
    public function isDownloadable(): bool
    {
        return $this->file_dokumen && Storage::disk('public')->exists($this->file_dokumen);
    }

    public function getDownloadCount(): int
    {
        // You can implement download tracking here if needed
        return 0;
    }

    public function incrementDownloadCount(): void
    {
        // Implement download count increment if needed
        // $this->increment('download_count');
    }
}