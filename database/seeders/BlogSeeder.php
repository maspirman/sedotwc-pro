<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Jasa Sedot WC Surabaya Profesional dan Terpercaya | Pelayanan Cepat & Bergaransi',
                'content' => '<h2>Jasa Sedot WC Surabaya Profesional dan Terpercaya | Pelayanan Cepat & Bergaransi</h2>

<p>Apakah Anda sedang mencari jasa sedot WC Surabaya yang cepat, profesional, dan harga terjangkau? Kami hadir untuk memberikan solusi terbaik atas permasalahan WC mampet, penuh, atau saluran tersumbat di rumah maupun tempat usaha Anda. Dengan pengalaman bertahun-tahun di bidang ini, kami siap melayani seluruh area Surabaya dan sekitarnya, termasuk Gresik, Sidoarjo, dan Mojokerto.</p>

<h3>Mengapa Harus Memilih Jasa Sedot WC Surabaya dari Kami?</h3>

<p>Berikut beberapa alasan mengapa pelanggan kami puas dan terus menggunakan layanan kami:</p>

<ul>
<li><strong>✅ Pelayanan Cepat & Tepat Waktu</strong><br>
Kami memahami bahwa masalah WC tidak bisa ditunda. Tim kami selalu siap siaga dan dapat datang ke lokasi Anda dalam waktu singkat.</li>

<li><strong>✅ Harga Transparan & Terjangkau</strong><br>
Tidak perlu khawatir soal biaya! Kami memberikan harga sedot WC yang kompetitif dan sesuai dengan pekerjaan yang dilakukan, tanpa biaya tersembunyi.</li>

<li><strong>✅ Teknisi Berpengalaman & Peralatan Modern</strong><br>
Kami menggunakan mobil tangki vakum bertekanan tinggi dan alat pendukung lainnya untuk memastikan proses sedot WC berjalan bersih, cepat, dan tanpa merusak instalasi saluran Anda.</li>

<li><strong>✅ Layanan Bergaransi</strong><br>
Kami memberikan garansi kerja, sehingga Anda tidak perlu khawatir jika masalah kembali terjadi dalam waktu dekat.</li>
</ul>

<h3>Layanan yang Kami Tawarkan:</h3>

<ul>
<li>Sedot WC penuh atau mampet</li>
<li>Perbaikan dan pembersihan saluran air mampet</li>
<li>Sedot limbah industri dan rumah tangga</li>
<li>Perawatan septic tank secara berkala</li>
<li>Instalasi dan perbaikan saluran pipa WC</li>
</ul>

<h3>Area Layanan Kami:</h3>

<p>Kami melayani seluruh wilayah Surabaya, termasuk:</p>

<ul>
<li><strong>Sedot WC Surabaya Timur:</strong> Rungkut, Gunung Anyar, Sukolilo</li>
<li><strong>Sedot WC Surabaya Barat:</strong> Tandes, Pakal, Lakarsantri</li>
<li><strong>Sedot WC Surabaya Selatan:</strong> Wonokromo, Gayungan, Wiyung</li>
<li><strong>Sedot WC Surabaya Utara:</strong> Kenjeran, Bulak, Pabean Cantikan</li>
<li><strong>Sedot WC Surabaya Pusat:</strong> Tegalsari, Genteng, Simokerto</li>
</ul>

<p>Termasuk juga wilayah sekitar seperti Sidoarjo, Gresik, dan Mojokerto.</p>

<h3>Kapan Harus Menyewa Jasa Sedot WC?</h3>

<p>Beberapa tanda WC atau septic tank Anda perlu disedot:</p>

<ul>
<li>Air WC mengalir lambat atau mampet</li>
<li>Muncul bau tidak sedap dari kamar mandi</li>
<li>WC penuh atau meluap saat digunakan</li>
<li>Sudah lebih dari 2 tahun sejak terakhir sedot WC</li>
</ul>

<p><strong>Jangan tunggu sampai masalah makin parah! Hubungi kami segera untuk penanganan cepat dan aman.</strong></p>

<h3>Hubungi Kami Sekarang!</h3>

<ul>
<li>📞 [Masukkan Nomor Telepon Anda]</li>
<li>📍 [Alamat Kantor Anda atau Lokasi Layanan]</li>
<li>🌐 [URL Website Anda]</li>
</ul>

<p><em>Tersedia layanan 24 jam untuk keadaan darurat! Kami siap membantu Anda kapan saja.</em></p>

<h3>Kesimpulan</h3>

<p>Sedot WC bukan hanya soal menguras septic tank, tapi juga tentang menjaga kebersihan, kenyamanan, dan kesehatan lingkungan rumah Anda. Dengan memilih jasa sedot WC Surabaya yang profesional, Anda bisa menghindari risiko kerusakan lebih parah dan biaya perbaikan yang mahal.</p>

<p><strong>Percayakan kebutuhan sedot WC Anda kepada kami. Profesional, cepat, dan bergaransi!</strong></p>',
                'category_id' => 2,
                'meta_title' => 'Jasa Sedot WC Surabaya Profesional dan Terpercaya | Pelayanan Cepat & Bergaransi',
                'meta_description' => 'Cari jasa sedot WC Surabaya cepat, profesional, dan bergaransi? Kami siap melayani seluruh Surabaya dengan harga terjangkau dan teknisi berpengalaman.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
                'views' => 150,
            ],
            [
                'title' => 'Panduan Lengkap Perawatan WC di Rumah',
                'content' => '<p>Menjaga kebersihan WC merupakan hal penting untuk kesehatan keluarga. Artikel ini akan membahas cara perawatan WC yang efektif dan mudah dilakukan di rumah.</p><h2>Tips Perawatan WC</h2><p>Pertama, pastikan untuk membersihkan WC secara rutin minimal seminggu sekali. Gunakan pembersih yang sesuai dengan material WC Anda.</p><h2>Pencegahan Penyumbatan</h2><p>Hindari membuang benda-benda yang tidak larut air ke dalam WC seperti tisu, pembalut, atau plastik.</p>',
                'category_id' => 1,
                'meta_title' => 'Panduan Lengkap Perawatan WC di Rumah',
                'meta_description' => 'Pelajari cara merawat WC dengan benar untuk menjaga kebersihan dan kesehatan keluarga Anda.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
                'views' => 150,
            ],
            [
                'title' => 'Mengapa WC Anda Mudah Mampet? Penyebab dan Solusinya',
                'content' => '<p>WC yang sering mampet bisa sangat mengganggu aktivitas sehari-hari. Mari kita bahas penyebab umum penyumbatan WC dan cara mengatasinya.</p><h2>Penyebab Utama Penyumbatan</h2><ul><li>Akumulasi kotoran yang tidak terurai</li><li>Penggunaan tisu yang tidak ramah lingkungan</li><li>Benda asing yang terbuang ke WC</li></ul><h2>Layanan Sedot WC Profesional</h2><p>Ketika WC mampet parah, sebaiknya gunakan jasa sedot WC profesional untuk menghindari kerusakan lebih lanjut.</p>',
                'category_id' => 2,
                'meta_title' => 'Penyebab WC Mudah Mampet dan Cara Mengatasinya',
                'meta_description' => 'Kenali penyebab WC mudah mampet dan solusi efektif untuk mengatasi masalah tersebut.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
                'views' => 89,
            ],
            [
                'title' => 'Dampak Kesehatan dari WC yang Tidak Bersih',
                'content' => '<p>WC yang tidak bersih tidak hanya menimbulkan bau tidak sedap, tetapi juga dapat berdampak buruk pada kesehatan. Mari kita bahas risikonya.</p><h2>Risiko Kesehatan</h2><p>WC kotor dapat menjadi sarang bakteri dan virus yang menyebabkan berbagai penyakit seperti diare, infeksi saluran kemih, dan masalah kulit.</p><h2>Pentingnya Kebersihan WC</h2><p>Menjaga kebersihan WC adalah investasi kesehatan untuk seluruh keluarga.</p>',
                'category_id' => 3,
                'meta_title' => 'Dampak Kesehatan dari WC Tidak Bersih',
                'meta_description' => 'Pelajari risiko kesehatan yang ditimbulkan dari WC yang tidak bersih dan pentingnya menjaga kebersihan.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
                'views' => 67,
            ],
            [
                'title' => 'Teknologi Modern dalam Layanan Sedot WC',
                'content' => '<p>Perkembangan teknologi telah membawa inovasi dalam layanan sedot WC. Artikel ini membahas teknologi terbaru yang digunakan dalam industri ini.</p><h2>Alat Sedot Modern</h2><p>Alat sedot WC modern menggunakan sistem vakum yang lebih efisien dan ramah lingkungan.</p><h2>Keunggulan Teknologi Baru</h2><p>Teknologi baru memungkinkan pembersihan yang lebih menyeluruh dan cepat.</p>',
                'category_id' => 4,
                'meta_title' => 'Teknologi Modern dalam Layanan Sedot WC',
                'meta_description' => 'Eksplorasi perkembangan teknologi terbaru dalam layanan sedot WC dan keunggulannya.',
                'status' => 'draft',
                'views' => 0,
            ],
            [
                'title' => 'Cara Memilih Jasa Sedot WC Terpercaya',
                'content' => '<p>Memilih jasa sedot WC yang tepat sangat penting untuk mendapatkan layanan yang berkualitas. Berikut adalah tips memilih jasa sedot WC terpercaya.</p><h2>Kriteria Jasa Terpercaya</h2><ul><li>Berkedudukan resmi</li><li>Memiliki tenaga ahli bersertifikat</li><li>Menggunakan peralatan modern</li><li>Memberikan garansi</li></ul><h2>Tips Memilih Jasa</h2><p>Periksa ulasan pelanggan dan bandingkan harga sebelum memutuskan.</p>',
                'category_id' => 2,
                'meta_title' => 'Cara Memilih Jasa Sedot WC Terpercaya',
                'meta_description' => 'Panduan lengkap memilih jasa sedot WC terpercaya dengan kriteria yang tepat.',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(1),
                'views' => 45,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blog = Blog::create($blogData);

            // Attach random tags to each blog
            $tags = Tag::inRandomOrder()->take(rand(2, 4))->pluck('id');
            $blog->tags()->attach($tags);
        }
    }
}
