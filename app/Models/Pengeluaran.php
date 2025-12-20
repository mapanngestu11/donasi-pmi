<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'rincian',
        'besar_anggaran',
        'file',
        'penanggung_jawab',
        'foto',
    ];

    protected $casts = [
        'besar_anggaran' => 'decimal:2',
    ];

    /**
     * Get file URL
     */
    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return asset('storage/pengeluaran/files/' . $this->file);
        }
        return null;
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/pengeluaran/fotos/' . $this->foto);
        }
        return null;
    }
}

