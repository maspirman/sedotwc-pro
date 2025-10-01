<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>Selamat Datang di SedotWC</h2>

<p>SedotWC adalah perusahaan jasa sedot WC profesional yang telah melayani masyarakat Indonesia sejak tahun 2018. Kami berkomitmen memberikan layanan sedot WC berkualitas tinggi dengan harga terjangkau dan pelayanan yang ramah.</p>

<h3>Visi Kami</h3>
<p>Menjadi perusahaan jasa sedot WC terdepan di Indonesia yang memberikan pelayanan terbaik dengan teknologi modern dan tim profesional.</p>

<h3>Misi Kami</h3>
<ul>
<li>Memberikan layanan sedot WC yang cepat, bersih, dan profesional</li>
<li>Menggunakan peralatan modern dan ramah lingkungan</li>
<li>Mendidik masyarakat tentang pentingnya kebersihan WC</li>
<li>Menjaga kepuasan pelanggan sebagai prioritas utama</li>
<li>Berkontribusi pada kesehatan masyarakat melalui layanan kebersihan</li>
</ul>

<h3>Tim Kami</h3>
<p>Tim SedotWC terdiri dari teknisi profesional yang telah berpengalaman lebih dari 5 tahun di bidang jasa sedot WC. Setiap teknisi kami telah melalui pelatihan khusus dan menggunakan peralatan modern untuk memberikan hasil terbaik.</p>

<h3>Komitmen Kami</h3>
<p>Kami berkomitmen untuk:</p>
<ul>
<li>Layanan 24 jam untuk keadaan darurat</li>
<li>Harga transparan tanpa biaya tersembunyi</li>
<li>Garansi kepuasan 100%</li>
<li>Penggunaan bahan ramah lingkungan</li>
<li>Pelayanan yang ramah dan profesional</li>
</ul>',
                'meta_title' => 'Tentang SedotWC - Jasa Sedot WC Profesional',
                'meta_description' => 'Pelajari lebih lanjut tentang SedotWC, perusahaan jasa sedot WC profesional dengan pengalaman lebih dari 5 tahun melayani masyarakat Indonesia.',
                'meta_keywords' => 'tentang sedot wc, profil perusahaan, visi misi sedot wc',
                'status' => 'active',
                'template' => 'default',
            ],
            [
                'title' => 'Kontak Kami',
                'slug' => 'kontak',
                'content' => '<h2>Hubungi Kami</h2>

<p>Jangan ragu untuk menghubungi kami kapan saja. Tim kami siap membantu Anda dengan layanan sedot WC terbaik.</p>

<h3>Informasi Kontak</h3>

<div class="row">
<div class="col-md-6">
<h4>Kantor Pusat</h4>
<p>Jl. Sudirman No. 123<br>
Jakarta Pusat, DKI Jakarta 10230<br>
Indonesia</p>
</div>
<div class="col-md-6">
<h4>Layanan Pelanggan</h4>
<p>Senin - Minggu: 24 Jam<br>
Untuk keadaan darurat</p>
</div>
</div>

<h3>Cara Menghubungi Kami</h3>

<h4>Telepon</h4>
<p><strong>(021) 1234-5678</strong><br>
Senin - Jumat: 08:00 - 17:00 WIB<br>
Sabtu - Minggu: 09:00 - 16:00 WIB</p>

<h4>WhatsApp</h4>
<p><strong>0812-3456-7890</strong><br>
Layanan 24 jam untuk pemesanan dan informasi</p>

<h4>Email</h4>
<p><strong>info@sedotwc.com</strong><br>
Untuk pertanyaan umum dan kerjasama<br>
<strong>emergency@sedotwc.com</strong><br>
Untuk layanan darurat</p>

<h3>Form Kontak</h3>
<p>Atau Anda dapat mengisi form kontak di bawah ini untuk mengirim pesan kepada kami:</p>

<div class="contact-form">
<form>
<div class="mb-3">
<label class="form-label">Nama Lengkap</label>
<input type="text" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">Nomor Telepon</label>
<input type="tel" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">Subjek</label>
<select class="form-control" required>
<option>Pemesanan Layanan</option>
<option>Pertanyaan Umum</option>
<option>Keluhan</option>
<option>Kerjasama</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Pesan</label>
<textarea class="form-control" rows="5" required></textarea>
</div>
<button type="submit" class="btn btn-primary">Kirim Pesan</button>
</form>
</div>

<h3>Lokasi Kami</h3>
<p>Kami melayani area Jakarta dan sekitarnya. Untuk area di luar Jakarta, silakan hubungi kami untuk informasi lebih lanjut.</p>

<h3>Media Sosial</h3>
<p>Ikuti kami di media sosial untuk mendapatkan informasi terbaru tentang layanan kami:</p>
<ul>
<li><a href="#">Facebook: @sedotwc</a></li>
<li><a href="#">Instagram: @sedotwc_id</a></li>
<li><a href="#">Twitter: @sedotwc</a></li>
</ul>',
                'meta_title' => 'Kontak SedotWC - Hubungi Kami 24 Jam',
                'meta_description' => 'Hubungi SedotWC untuk layanan sedot WC 24 jam. Telepon, WhatsApp, email, dan lokasi kantor tersedia.',
                'meta_keywords' => 'kontak sedot wc, hubungi sedot wc, telepon sedot wc, whatsapp sedot wc',
                'status' => 'active',
                'template' => 'contact',
            ],
            [
                'title' => 'FAQ - Pertanyaan Umum',
                'slug' => 'faq',
                'content' => '<h2>Pertanyaan yang Sering Diajukan</h2>

<p>Berikut adalah beberapa pertanyaan yang sering diajukan oleh pelanggan kami. Jika Anda tidak menemukan jawaban yang dicari, silakan hubungi kami.</p>

<h3>Layanan</h3>

<h4>Apakah Anda melayani 24 jam?</h4>
<p>Ya, kami menyediakan layanan 24 jam untuk keadaan darurat. Namun untuk pemesanan reguler, kami beroperasi dari pukul 08:00 - 17:00 WIB.</p>

<h4>Berapa lama proses sedot WC?</h4>
<p>Waktu pengerjaan tergantung pada kondisi WC. Rata-rata 30-60 menit untuk WC standar. Untuk kondisi yang lebih parah, mungkin memakan waktu lebih lama.</p>

<h4>Apakah menggunakan bahan kimia berbahaya?</h4>
<p>Tidak, kami menggunakan bahan-bahan yang ramah lingkungan dan tidak berbahaya bagi kesehatan manusia dan lingkungan.</p>

<h4>Apakah ada garansi layanan?</h4>
<p>Ya, kami memberikan garansi kepuasan 100%. Jika Anda tidak puas dengan layanan kami, kami akan perbaiki tanpa biaya tambahan.</p>

<h3>Harga</h3>

<h4>Berapa harga sedot WC?</h4>
<p>Harga tergantung pada jenis layanan yang dipilih:</p>
<ul>
<li>Sedot WC Standar: Rp 150.000</li>
<li>Sedot WC Premium: Rp 250.000</li>
<li>Sedot WC + Pembersihan: Rp 300.000</li>
<li>Sedot WC Darurat 24 Jam: Rp 400.000</li>
</ul>

<h4>Apakah ada biaya tambahan?</h4>
<p>Harga yang tercantum sudah termasuk biaya transportasi dalam radius 10km dari kantor kami. Untuk jarak lebih jauh, akan dikenakan biaya transportasi tambahan.</p>

<h4>Apakah bisa nego harga?</h4>
<p>Harga yang kami tawarkan sudah sangat kompetitif. Namun untuk pelanggan tetap atau order dalam jumlah besar, kami bisa memberikan diskon khusus.</p>

<h3>Pemesanan</h3>

<h4>Bagaimana cara memesan layanan?</h4>
<p>Anda bisa memesan melalui telepon, WhatsApp, email, atau langsung melalui website kami. Kami akan mengkonfirmasi pesanan dalam waktu 1 jam.</p>

<h4>Berapa lama estimasi waktu kedatangan?</h4>
<p>Untuk area Jakarta, estimasi kedatangan 1-2 jam setelah konfirmasi. Untuk daerah lain tergantung jarak dan kondisi lalu lintas.</p>

<h4>Bisa pesan untuk besok hari?</h4>
<p>Tentu, Anda bisa memesan untuk hari berikutnya. Kami sarankan untuk memesan di pagi hari agar bisa mendapat slot waktu yang diinginkan.</p>

<h4>Apakah bisa cancel pesanan?</h4>
<p>Pesanan bisa dicancel maksimal 2 jam sebelum waktu yang dijadwalkan tanpa dikenakan biaya. Untuk cancel di waktu yang lebih dekat, akan dikenakan biaya administrasi.</p>

<h3>Teknis</h3>

<h4>Apa yang dilakukan saat sedot WC?</h4>
<p>Tim kami akan membersihkan seluruh sistem saluran WC menggunakan peralatan modern, menghilangkan sumbatan, dan melakukan pembersihan menyeluruh.</p>

<h4>Apakah perlu persiapan khusus?</h4>
<p>Tidak ada persiapan khusus yang diperlukan. Pastikan saja area WC bisa diakses oleh tim kami dan tidak ada barang berharga yang ditinggal di area kerja.</p>

<h4>Apakah aman untuk anak-anak dan hewan peliharaan?</h4>
<p>Tim kami akan bekerja dengan hati-hati. Namun untuk keselamatan, kami sarankan untuk menjauhkan anak-anak dan hewan peliharaan dari area kerja selama proses berlangsung.</p>

<h4>Apakah ada efek samping setelah sedot WC?</h4>
<p>Biasanya tidak ada efek samping. Namun jika WC Anda sudah sangat lama tidak dibersihkan, mungkin akan ada bau yang cukup menyengat selama 1-2 hari pertama.</p>

<h3>Lainnya</h3>

<h4>Apakah Anda memiliki asuransi?</h4>
<p>Ya, tim kami dilengkapi dengan asuransi untuk melindungi Anda dan properti Anda selama proses pengerjaan.</p>

<h4>Bagaimana cara pembayaran?</h4>
<p>Kami menerima pembayaran tunai, transfer bank, dan e-wallet (GoPay, OVO, Dana, LinkAja).</p>

<h4>Apakah ada layanan antar jemput?</h4>
<p>Untuk saat ini kami belum menyediakan layanan antar jemput. Tim kami akan datang langsung ke lokasi Anda.</p>

<p><strong>Masih ada pertanyaan?</strong> Jangan ragu untuk menghubungi kami di <a href="tel:+622112345678">(021) 1234-5678</a> atau <a href="https://wa.me/6281234567890">WhatsApp</a>.</p>',
                'meta_title' => 'FAQ SedotWC - Pertanyaan Umum Layanan Sedot WC',
                'meta_description' => 'Jawaban lengkap untuk pertanyaan umum tentang layanan sedot WC, harga, pemesanan, dan teknis lainnya.',
                'meta_keywords' => 'faq sedot wc, pertanyaan sedot wc, tanya jawab sedot wc',
                'status' => 'active',
                'template' => 'faq',
            ],
        ];

        foreach ($pages as $page) {
            \App\Models\CmsPage::create($page);
        }
    }
}
