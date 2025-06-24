<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'title',
        'slug',
        'tgl_publikasi',
        'author',
        'image',
        'content'
    ];

    protected $casts = [
        'tgl_publikasi' => 'date',
    ];

    /**
     * Boot method untuk auto generate slug
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto generate slug saat creating record baru
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = static::generateUniqueSlug($berita->title);
            }
        });
        
        // Auto update slug saat title berubah (opsional)
        static::updating(function ($berita) {
            // Hanya update slug jika title berubah dan slug kosong atau sama dengan slug lama dari title
            if ($berita->isDirty('title') && (empty($berita->slug) || $berita->slug === Str::slug($berita->getOriginal('title')))) {
                $berita->slug = static::generateUniqueSlug($berita->title, $berita->id);
            }
        });
    }

    /**
     * Generate unique slug
     */
    private static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Cek apakah slug sudah ada, jika ya tambahkan counter
        while (static::where('slug', $slug)->when($ignoreId, function($query, $ignoreId) {
            return $query->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Accessor untuk format tanggal yang lebih mudah dibaca
    public function getFormattedTglPublikasiAttribute()
    {
        return $this->tgl_publikasi->format('d M Y');
    }

    // Accessor untuk excerpt content
    public function getExcerptAttribute($limit = 150)
    {
        $content = strip_tags($this->content); // Remove HTML tags
        return strlen($content) > $limit 
            ? substr($content, 0, $limit) . '...' 
            : $content;
    }

    // Accessor untuk URL berdasarkan slug
    public function getUrlAttribute()
    {
        return route('berita.show', $this->slug);
    }

    // Scope untuk mengurutkan berdasarkan tanggal publikasi terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('tgl_publikasi', 'desc');
    }

    // Scope untuk berita yang dipublikasi
    public function scopePublished($query)
    {
        return $query->where('tgl_publikasi', '<=', now());
    }

    // Scope untuk berita draft
    public function scopeDraft($query)
    {
        return $query->where('tgl_publikasi', '>', now());
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
        });
    }

    // Method untuk mengecek apakah berita sudah published
    public function isPublished()
    {
        return $this->tgl_publikasi <= now();
    }

    // Method untuk mendapatkan status publikasi
    public function getStatusAttribute()
    {
        return $this->isPublished() ? 'Published' : 'Draft';
    }
}