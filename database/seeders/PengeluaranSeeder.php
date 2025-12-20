<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Schema;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Check if table exists
        if (!Schema::hasTable('pengeluarans')) {
            $this->command->error('Tabel pengeluarans belum ada. Silakan jalankan migration terlebih dahulu!');
            $this->command->info('Jalankan: php artisan migrate');
            return;
        }

        $pengeluarans = [
            [
                'nama_kegiatan' => 'Bantuan Kemanusiaan untuk Korban Banjir Jakarta',
                'rincian' => 'Pembelian makanan siap saji, pakaian layak pakai, selimut, air bersih, dan kebutuhan pokok lainnya untuk korban banjir di Jakarta. Distribusi dilakukan di 5 titik lokasi banjir dengan total 200 kepala keluarga.',
                'besar_anggaran' => 50000000.00,
                'file' => null,
                'penanggung_jawab' => 'Dr. H. Rizal Hidayat',
                'foto' => null,
            ],
            [
                'nama_kegiatan' => 'Program Donor Darah PMI',
                'rincian' => 'Biaya operasional program donor darah serentak di 10 titik, meliputi: transportasi tim medis, peralatan medis (jarum suntik, kantong darah, dll), konsumsi relawan, dan promosi kegiatan. Program berhasil mengumpulkan 1000 kantong darah.',
                'besar_anggaran' => 35000000.00,
                'file' => null,
                'penanggung_jawab' => 'Siti Nurhaliza, S.Kep',
                'foto' => null,
            ],
            [
                'nama_kegiatan' => 'Pelatihan Pertolongan Pertama untuk Masyarakat',
                'rincian' => 'Biaya pelatihan pertolongan pertama untuk 50 peserta, meliputi: honor instruktur, bahan pelatihan (manekin CPR, perban, bidai, dll), konsumsi peserta, sertifikat, dan modul pelatihan. Pelatihan dilaksanakan selama 2 hari.',
                'besar_anggaran' => 25000000.00,
                'file' => null,
                'penanggung_jawab' => 'Ahmad Fauzi, S.Kep., Ners',
                'foto' => null,
            ],
            [
                'nama_kegiatan' => 'Bantuan Evakuasi Korban Gempa Sulawesi Tengah',
                'rincian' => 'Biaya operasional tim relawan PMI untuk evakuasi korban gempa, meliputi: transportasi tim dan peralatan, tenda darurat, peralatan medis, logistik tim (makanan, minuman), dan komunikasi. Tim terdiri dari 30 relawan yang bertugas selama 7 hari.',
                'besar_anggaran' => 75000000.00,
                'file' => null,
                'penanggung_jawab' => 'Budi Santoso, S.KM',
                'foto' => null,
            ],
            [
                'nama_kegiatan' => 'Program Bantuan Pendidikan untuk Anak Yatim',
                'rincian' => 'Bantuan pendidikan untuk 100 anak yatim dan dhuafa, meliputi: beasiswa pendidikan, seragam sekolah, buku pelajaran, alat tulis, tas sekolah, dan sepatu. Program dilaksanakan bekerjasama dengan 10 sekolah di berbagai wilayah.',
                'besar_anggaran' => 60000000.00,
                'file' => null,
                'penanggung_jawab' => 'Dewi Sartika, S.Pd',
                'foto' => null,
            ],
        ];

        foreach ($pengeluarans as $pengeluaran) {
            try {
                Pengeluaran::updateOrCreate(
                    ['nama_kegiatan' => $pengeluaran['nama_kegiatan']],
                    $pengeluaran
                );
            } catch (\Exception $e) {
                $this->command->warn('Gagal menyimpan: ' . $pengeluaran['nama_kegiatan'] . ' - ' . $e->getMessage());
            }
        }

        $this->command->info('Data pengeluaran berhasil dibuat!');
    }
}

