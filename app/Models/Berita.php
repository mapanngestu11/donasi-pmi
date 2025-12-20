<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_berita_id',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'penulis',
        'views',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship with KategoriBerita
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }

    /**
     * Scope untuk berita yang dipublikasikan
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function($q) {
                $q->where('published_at', '<=', now())
                  ->orWhereNull('published_at');
            });
    }

    /**
     * Scope untuk berita terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get gambar URL
     */
    public function getGambarUrlAttribute()
    {
        // Jika ada gambar, langsung return URL dengan storage prefix
        // Jangan cek file_exists karena bisa gagal untuk symlink
        // Biarkan browser handle 404 dan onerror handler akan menangani
        if ($this->gambar) {
            // Check if gambar is already a full URL
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }
            
            // Jika gambar sudah memiliki prefix storage/, langsung return
            if (strpos($this->gambar, 'storage/') === 0) {
                return asset($this->gambar);
            }
            
            // Langsung return dengan storage prefix
            // Ini akan bekerja untuk storage:link symlink
            return asset('storage/' . $this->gambar);
        }
        
        // Jika tidak ada gambar, return null agar bisa di-handle di view
        // View akan menggunakan placeholder
        return null;
    }
}
