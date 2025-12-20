<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = KategoriBerita::all();
        
        if ($kategoris->isEmpty()) {
            $this->command->error('Kategori berita belum ada. Jalankan KategoriBeritaSeeder terlebih dahulu!');
            return;
        }

        $beritas = [
            [
                'judul' => 'PMI Gelar Bantuan Kemanusiaan untuk Korban Banjir di Jakarta',
                'ringkasan' => 'Palang Merah Indonesia (PMI) menggelar bantuan kemanusiaan untuk korban banjir di Jakarta. Bantuan berupa makanan, pakaian, dan kebutuhan pokok lainnya.',
                'konten' => '<p>Palang Merah Indonesia (PMI) kembali menggelar aksi kemanusiaan untuk membantu korban banjir yang melanda beberapa wilayah di Jakarta. Bantuan yang diberikan meliputi makanan siap saji, pakaian layak pakai, selimut, dan kebutuhan pokok lainnya.</p><p>Ketua PMI Jakarta, Dr. H. Rizal Hidayat, mengatakan bahwa tim relawan PMI telah dikerahkan ke lokasi-lokasi terdampak banjir untuk memberikan bantuan secepat mungkin. "Kami berkomitmen untuk membantu masyarakat yang terdampak bencana banjir ini," ujarnya.</p><p>Bantuan ini didukung oleh donasi dari berbagai pihak, baik individu maupun perusahaan. PMI mengucapkan terima kasih kepada semua pihak yang telah berpartisipasi dalam aksi kemanusiaan ini.</p>',
                'penulis' => 'Admin PMI',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'judul' => 'PMI Bantu Evakuasi Korban Gempa di Sulawesi Tengah',
                'ringkasan' => 'Tim relawan PMI membantu proses evakuasi dan memberikan bantuan medis kepada korban gempa bumi di Sulawesi Tengah.',
                'konten' => '<p>Tim relawan Palang Merah Indonesia (PMI) bergerak cepat untuk membantu proses evakuasi dan memberikan bantuan medis kepada korban gempa bumi yang terjadi di Sulawesi Tengah. Gempa dengan magnitudo 6,2 SR tersebut menyebabkan kerusakan pada beberapa bangunan dan menimbulkan korban luka-luka.</p><p>Tim medis PMI telah mendirikan posko kesehatan di beberapa titik untuk memberikan pertolongan pertama kepada korban. Selain itu, PMI juga mengirimkan bantuan logistik berupa tenda, selimut, dan makanan siap saji.</p><p>"Kami akan terus memantau kondisi korban dan memberikan bantuan sesuai kebutuhan," kata Koordinator Tim PMI di lokasi bencana.</p>',
                'penulis' => 'Tim Relawan PMI',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'judul' => 'Program Donor Darah PMI Capai Target 1000 Kantong',
                'ringkasan' => 'Program donor darah yang digelar PMI berhasil mencapai target 1000 kantong darah dalam satu hari. Kegiatan ini mendapat antusiasme tinggi dari masyarakat.',
                'konten' => '<p>Program donor darah yang digelar Palang Merah Indonesia (PMI) di berbagai kota berhasil mencapai target 1000 kantong darah dalam satu hari. Kegiatan yang digelar serentak di 10 titik ini mendapat antusiasme tinggi dari masyarakat.</p><p>Ketua PMI Pusat, Jusuf Kalla, mengapresiasi partisipasi masyarakat dalam program donor darah ini. "Kami sangat berterima kasih kepada semua pendonor yang telah menyumbangkan darahnya untuk membantu sesama," ujarnya.</p><p>Darah yang terkumpul akan didistribusikan ke berbagai rumah sakit untuk membantu pasien yang membutuhkan transfusi darah. PMI berharap program ini dapat terus dilaksanakan secara rutin.</p>',
                'penulis' => 'Tim Komunikasi PMI',
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'judul' => 'PMI Luncurkan Program Bantuan Pendidikan untuk Anak Yatim',
                'ringkasan' => 'PMI meluncurkan program bantuan pendidikan berupa beasiswa dan perlengkapan sekolah untuk anak yatim dan dhuafa.',
                'konten' => '<p>Palang Merah Indonesia (PMI) meluncurkan program bantuan pendidikan untuk anak yatim dan dhuafa. Program ini memberikan beasiswa pendidikan dan perlengkapan sekolah kepada anak-anak yang membutuhkan.</p><p>Program ini diharapkan dapat membantu mengurangi angka putus sekolah dan memberikan kesempatan yang sama bagi semua anak untuk mendapatkan pendidikan yang layak. "Pendidikan adalah investasi terbaik untuk masa depan," kata Direktur Program PMI.</p><p>Bantuan yang diberikan meliputi biaya sekolah, seragam, buku, dan alat tulis. PMI bekerja sama dengan berbagai sekolah dan yayasan untuk menjalankan program ini.</p>',
                'penulis' => 'Tim Program PMI',
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'judul' => 'PMI Gelar Pelatihan Pertolongan Pertama untuk Masyarakat',
                'ringkasan' => 'PMI menggelar pelatihan pertolongan pertama (first aid) untuk masyarakat umum. Pelatihan ini bertujuan meningkatkan kesadaran akan pentingnya pertolongan pertama.',
                'konten' => '<p>Palang Merah Indonesia (PMI) menggelar pelatihan pertolongan pertama (first aid) untuk masyarakat umum. Pelatihan yang diikuti oleh 50 peserta ini bertujuan meningkatkan kesadaran dan kemampuan masyarakat dalam memberikan pertolongan pertama pada kondisi darurat.</p><p>Materi pelatihan meliputi penanganan luka, patah tulang, henti jantung, dan berbagai kondisi darurat lainnya. Peserta juga diajarkan cara melakukan resusitasi jantung paru (RJP) dan menggunakan alat bantu pernapasan.</p><p>"Dengan pelatihan ini, diharapkan masyarakat dapat memberikan pertolongan pertama yang tepat sebelum bantuan medis tiba," ujar Instruktur PMI.</p>',
                'penulis' => 'Tim Pelatihan PMI',
                'is_published' => true,
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($beritas as $index => $berita) {
            // Ambil kategori secara bergantian
            $kategori = $kategoris[$index % $kategoris->count()];
            
            Berita::updateOrCreate(
                ['slug' => Str::slug($berita['judul'])],
                array_merge($berita, [
                    'kategori_berita_id' => $kategori->id,
                    'views' => rand(50, 500),
                ])
            );
        }

        $this->command->info('Berita berhasil dibuat!');
    }
}

