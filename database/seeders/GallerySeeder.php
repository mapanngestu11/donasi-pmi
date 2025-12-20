<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $galleries = [
            [
                'judul_kegiatan' => 'Bantuan Kemanusiaan untuk Korban Banjir Jakarta',
                'deskripsi' => 'Tim relawan PMI memberikan bantuan kemanusiaan berupa makanan, pakaian, dan kebutuhan pokok lainnya kepada korban banjir di Jakarta. Kegiatan ini diikuti oleh 50 relawan yang tersebar di berbagai titik lokasi banjir.',
                'gambar' => 'bantuan-banjir-jakarta.jpg',
                'tanggal' => now()->subDays(5),
            ],
            [
                'judul_kegiatan' => 'Program Donor Darah PMI',
                'deskripsi' => 'PMI menggelar program donor darah serentak di 10 titik di berbagai kota. Kegiatan ini berhasil mengumpulkan lebih dari 1000 kantong darah yang akan didistribusikan ke rumah sakit. Masyarakat sangat antusias berpartisipasi dalam kegiatan ini.',
                'gambar' => 'donor-darah-pmi.jpg',
                'tanggal' => now()->subDays(10),
            ],
            [
                'judul_kegiatan' => 'Pelatihan Pertolongan Pertama untuk Masyarakat',
                'deskripsi' => 'PMI mengadakan pelatihan pertolongan pertama (first aid) untuk masyarakat umum. Pelatihan diikuti oleh 50 peserta yang belajar tentang penanganan luka, patah tulang, henti jantung, dan resusitasi jantung paru (RJP).',
                'gambar' => 'pelatihan-pertolongan-pertama.jpg',
                'tanggal' => now()->subDays(15),
            ],
            [
                'judul_kegiatan' => 'Bantuan Evakuasi Korban Gempa Sulawesi Tengah',
                'deskripsi' => 'Tim relawan PMI membantu proses evakuasi dan memberikan bantuan medis kepada korban gempa bumi di Sulawesi Tengah. Tim medis PMI mendirikan posko kesehatan di beberapa titik untuk memberikan pertolongan pertama kepada korban.',
                'gambar' => 'evakuasi-gempa-sulteng.jpg',
                'tanggal' => now()->subDays(20),
            ],
            [
                'judul_kegiatan' => 'Program Bantuan Pendidikan untuk Anak Yatim',
                'deskripsi' => 'PMI meluncurkan program bantuan pendidikan berupa beasiswa dan perlengkapan sekolah untuk anak yatim dan dhuafa. Program ini memberikan kesempatan yang sama bagi semua anak untuk mendapatkan pendidikan yang layak.',
                'gambar' => 'bantuan-pendidikan.jpg',
                'tanggal' => now()->subDays(25),
            ],
            [
                'judul_kegiatan' => 'Kegiatan Bakti Sosial di Panti Asuhan',
                'deskripsi' => 'Tim relawan PMI mengadakan bakti sosial di panti asuhan dengan memberikan bantuan berupa makanan, pakaian, dan perlengkapan sekolah. Kegiatan ini juga diisi dengan berbagai permainan edukatif untuk anak-anak panti asuhan.',
                'gambar' => 'baksos-panti-asuhan.jpg',
                'tanggal' => now()->subDays(30),
            ],
            [
                'judul_kegiatan' => 'Penyaluran Bantuan untuk Korban Kebakaran',
                'deskripsi' => 'PMI menyalurkan bantuan untuk korban kebakaran di kawasan padat penduduk. Bantuan yang diberikan meliputi tenda darurat, selimut, makanan siap saji, dan kebutuhan pokok lainnya. Tim relawan juga membantu proses evakuasi dan pendataan korban.',
                'gambar' => 'bantuan-kebakaran.jpg',
                'tanggal' => now()->subDays(35),
            ],
            [
                'judul_kegiatan' => 'Pelatihan Relawan PMI Muda',
                'deskripsi' => 'PMI mengadakan pelatihan untuk relawan PMI muda yang baru bergabung. Pelatihan meliputi materi tentang prinsip-prinsip PMI, teknik pertolongan pertama, manajemen bencana, dan komunikasi dalam situasi darurat. Sebanyak 30 relawan muda mengikuti pelatihan ini.',
                'gambar' => 'pelatihan-relawan-muda.jpg',
                'tanggal' => now()->subDays(40),
            ],
            [
                'judul_kegiatan' => 'Kampanye Kesehatan Masyarakat',
                'deskripsi' => 'PMI menggelar kampanye kesehatan masyarakat dengan memberikan layanan cek kesehatan gratis, konsultasi kesehatan, dan penyuluhan tentang pentingnya menjaga kesehatan. Kegiatan ini diikuti oleh ratusan warga dari berbagai kalangan.',
                'gambar' => 'kampanye-kesehatan.jpg',
                'tanggal' => now()->subDays(45),
            ],
            [
                'judul_kegiatan' => 'Penghargaan untuk Relawan Berprestasi',
                'deskripsi' => 'PMI memberikan penghargaan kepada relawan yang telah berdedikasi tinggi dalam berbagai kegiatan kemanusiaan. Acara penghargaan ini dihadiri oleh berbagai pihak dan menjadi momentum untuk mengapresiasi kontribusi para relawan.',
                'gambar' => 'penghargaan-relawan.jpg',
                'tanggal' => now()->subDays(50),
            ],
            [
                'judul_kegiatan' => 'Bantuan Logistik untuk Pengungsi Bencana Alam',
                'deskripsi' => 'PMI menyalurkan bantuan logistik berupa tenda, selimut, matras, dan perlengkapan darurat lainnya untuk pengungsi yang terdampak bencana alam. Bantuan didistribusikan ke berbagai posko pengungsian di daerah terdampak.',
                'gambar' => '', // Will be assigned from template images
                'tanggal' => now()->subDays(55),
            ],
            [
                'judul_kegiatan' => 'Program Vaksinasi Gratis untuk Masyarakat',
                'deskripsi' => 'PMI bekerja sama dengan dinas kesehatan menggelar program vaksinasi gratis untuk masyarakat. Program ini bertujuan meningkatkan cakupan vaksinasi dan melindungi masyarakat dari berbagai penyakit menular.',
                'gambar' => '', // Will be assigned from template images
                'tanggal' => now()->subDays(60),
            ],
        ];

        // Check if table exists
        if (!Schema::hasTable('galleries')) {
            $this->command->error('Tabel galleries belum ada. Silakan jalankan migration terlebih dahulu!');
            $this->command->info('Jalankan: php artisan migrate');
            return;
        }

        // Check if required columns exist
        $requiredColumns = ['judul_kegiatan', 'deskripsi', 'gambar', 'tanggal'];
        $missingColumns = [];
        foreach ($requiredColumns as $column) {
            if (!Schema::hasColumn('galleries', $column)) {
                $missingColumns[] = $column;
            }
        }

        if (!empty($missingColumns)) {
            $this->command->error('Kolom berikut tidak ditemukan di tabel galleries: ' . implode(', ', $missingColumns));
            $this->command->info('Silakan jalankan migration terlebih dahulu: php artisan migrate');
            return;
        }

        // Prepare images from template
        $templateImages = [
            'boy.png',
            'girl.png',
            'man.png',
            'logo.png',
            'logo2.png',
            'ss2.png',
            'phone.png'
        ];

        // Ensure gallery directory exists
        $galleryPath = storage_path('app/public/gallery');
        if (!File::exists($galleryPath)) {
            File::makeDirectory($galleryPath, 0755, true);
        }

        // Copy images from template to storage
        $imageSources = [
            'boy.png' => public_path('assets/admin/img/boy.png'),
            'girl.png' => public_path('assets/admin/img/girl.png'),
            'man.png' => public_path('assets/admin/img/man.png'),
            'logo.png' => public_path('assets/admin/img/logo/logo.png'),
            'logo2.png' => public_path('assets/admin/img/logo/logo2.png'),
            'ss2.png' => public_path('assets/admin/img/screenshot/ss2.png'),
            'phone.png' => public_path('assets/images/hero/phone.png'),
        ];

        $copiedImages = [];
        foreach ($imageSources as $filename => $sourcePath) {
            if (File::exists($sourcePath)) {
                $destinationPath = $galleryPath . '/' . $filename;
                File::copy($sourcePath, $destinationPath);
                $copiedImages[] = $filename;
                $this->command->info('Gambar disalin: ' . $filename);
            } else {
                $this->command->warn('Gambar tidak ditemukan: ' . $sourcePath);
            }
        }

        // Map galleries to available images (cycle through available images)
        $imageIndex = 0;
        $imageCount = count($copiedImages);

        // Insert data
        foreach ($galleries as $index => $gallery) {
            try {
                // Use available images, cycle if needed
                if ($imageCount > 0) {
                    $gallery['gambar'] = $copiedImages[$imageIndex % $imageCount];
                    $imageIndex++;
                } else {
                    // If no images available, use placeholder name
                    $gallery['gambar'] = 'placeholder.jpg';
                }

                Gallery::updateOrCreate(
                    ['judul_kegiatan' => $gallery['judul_kegiatan']],
                    $gallery
                );
            } catch (\Exception $e) {
                $this->command->warn('Gagal menyimpan: ' . $gallery['judul_kegiatan'] . ' - ' . $e->getMessage());
            }
        }

        $this->command->info('Data gallery berhasil dibuat dengan ' . count($copiedImages) . ' gambar!');
    }
}

