<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Kemanusiaan',
                'deskripsi' => 'Berita tentang kegiatan kemanusiaan dan bantuan sosial',
                'is_active' => true,
            ],
            [
                'nama' => 'Bencana Alam',
                'deskripsi' => 'Berita tentang penanganan bencana alam dan bantuan korban',
                'is_active' => true,
            ],
            [
                'nama' => 'Kesehatan',
                'deskripsi' => 'Berita tentang program kesehatan dan layanan medis',
                'is_active' => true,
            ],
            [
                'nama' => 'Pendidikan',
                'deskripsi' => 'Berita tentang program pendidikan dan beasiswa',
                'is_active' => true,
            ],
            [
                'nama' => 'Donasi',
                'deskripsi' => 'Berita tentang program donasi dan penggalangan dana',
                'is_active' => true,
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBerita::updateOrCreate(
                ['slug' => Str::slug($kategori['nama'])],
                $kategori
            );
        }

        $this->command->info('Kategori berita berhasil dibuat!');
    }
}

