<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Perkembangan Teknologi AI di Indonesia Semakin Pesat',
                'slug' => 'perkembangan-teknologi-ai-di-indonesia-semakin-pesat',
                'content' => '<p>Perkembangan teknologi Artificial Intelligence (AI) di Indonesia mengalami kemajuan yang sangat signifikan dalam beberapa tahun terakhir. Berbagai perusahaan teknologi lokal mulai mengadopsi dan mengembangkan solusi berbasis AI untuk berbagai sektor industri.</p>

<p>Menurut data dari Kementerian Komunikasi dan Informatika, investasi di bidang AI di Indonesia telah mencapai miliaran rupiah pada tahun ini. Hal ini menunjukkan antusiasme yang tinggi dari para investor terhadap potensi teknologi AI di tanah air.</p>

<p>Beberapa sektor yang paling banyak mengadopsi teknologi AI antara lain:</p>
<ul>
<li>Perbankan dan Fintech</li>
<li>E-commerce dan Retail</li>
<li>Kesehatan dan Farmasi</li>
<li>Transportasi dan Logistik</li>
<li>Pendidikan</li>
</ul>

<p>Pemerintah juga telah menyiapkan roadmap pengembangan AI nasional yang akan diluncurkan dalam waktu dekat. Roadmap ini diharapkan dapat menjadi panduan bagi pengembangan ekosistem AI yang berkelanjutan di Indonesia.</p>',
                'excerpt' => 'Perkembangan teknologi Artificial Intelligence (AI) di Indonesia mengalami kemajuan yang sangat signifikan dalam beberapa tahun terakhir...',
                'category_id' => 4, // Teknologi
                'author_id' => 3, // Wartawan
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'approved_by' => 2, // Editor
                'approved_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'views' => 1250,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'title' => 'Ekonomi Indonesia Tumbuh 5.2% di Kuartal Ketiga 2024',
                'slug' => 'ekonomi-indonesia-tumbuh-52-persen-kuartal-ketiga-2024',
                'content' => '<p>Badan Pusat Statistik (BPS) mengumumkan bahwa ekonomi Indonesia tumbuh 5.2% pada kuartal ketiga tahun 2024. Angka ini menunjukkan peningkatan yang positif dibandingkan kuartal sebelumnya yang mencapai 4.8%.</p>

<p>Pertumbuhan ekonomi ini didorong oleh beberapa faktor utama, antara lain:</p>
<ul>
<li>Peningkatan konsumsi rumah tangga</li>
<li>Investasi pemerintah yang meningkat</li>
<li>Ekspor yang mengalami recovery</li>
<li>Sektor pariwisata yang mulai pulih</li>
</ul>

<p>Menteri Keuangan menyatakan bahwa capaian ini sejalan dengan target pemerintah untuk mencapai pertumbuhan ekonomi 5.3% pada akhir tahun 2024. Berbagai stimulus ekonomi yang telah diluncurkan pemerintah terbukti efektif dalam mendorong pertumbuhan.</p>

<p>Sektor yang paling berkontribusi terhadap pertumbuhan adalah manufaktur, perdagangan, dan jasa keuangan. Sementara itu, sektor pertanian juga menunjukkan tren positif seiring dengan panen raya yang berlangsung di berbagai daerah.</p>',
                'excerpt' => 'Badan Pusat Statistik (BPS) mengumumkan bahwa ekonomi Indonesia tumbuh 5.2% pada kuartal ketiga tahun 2024...',
                'category_id' => 2, // Ekonomi
                'author_id' => 3, // Wartawan
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'approved_by' => 2, // Editor
                'approved_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'views' => 890,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'title' => 'Timnas Indonesia Lolos ke Babak 16 Besar Piala Asia 2024',
                'slug' => 'timnas-indonesia-lolos-babak-16-besar-piala-asia-2024',
                'content' => '<p>Tim Nasional Indonesia berhasil meloloskan diri ke babak 16 besar Piala Asia 2024 setelah mengalahkan Thailand dengan skor 2-1 dalam pertandingan terakhir fase grup. Kemenangan ini sekaligus mengantarkan Indonesia sebagai juara grup A.</p>

<p>Gol kemenangan Indonesia dicetak oleh Egy Maulana Vikri pada menit ke-78 setelah sebelumnya Thailand sempat unggul lebih dulu melalui gol Chanathip Songkrasin di menit ke-23. Indonesia kemudian menyamakan kedudukan melalui gol Witan Sulaeman di menit ke-65.</p>

<p>Pelatih Shin Tae-yong mengungkapkan rasa bangganya terhadap performa tim yang terus menunjukkan perkembangan positif. "Para pemain telah menunjukkan mental juara dan kerja keras yang luar biasa," ujarnya dalam konferensi pers pasca pertandingan.</p>

<p>Di babak 16 besar, Indonesia akan menghadapi juara grup B yang kemungkinan besar adalah Jepang atau Korea Selatan. Pertandingan dijadwalkan berlangsung pada akhir pekan ini di Stadion Nasional.</p>',
                'excerpt' => 'Tim Nasional Indonesia berhasil meloloskan diri ke babak 16 besar Piala Asia 2024 setelah mengalahkan Thailand dengan skor 2-1...',
                'category_id' => 3, // Olahraga
                'author_id' => 3, // Wartawan
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'approved_by' => 2, // Editor
                'approved_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'views' => 2150,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            ],
            [
                'title' => 'Presiden Resmikan Jembatan Terpanjang di Indonesia',
                'slug' => 'presiden-resmikan-jembatan-terpanjang-di-indonesia',
                'content' => '<p>Presiden Republik Indonesia meresmikan Jembatan Suramadu II yang menjadi jembatan terpanjang di Indonesia dengan panjang mencapai 15.2 kilometer. Jembatan ini menghubungkan Pulau Jawa dan Pulau Madura bagian timur.</p>

<p>Dalam sambutannya, Presiden menyatakan bahwa pembangunan jembatan ini merupakan bagian dari komitmen pemerintah untuk meningkatkan konektivitas antar pulau dan mendorong pertumbuhan ekonomi di wilayah timur Jawa.</p>

<p>Jembatan yang dibangun dengan teknologi terdepan ini memiliki beberapa keunggulan:</p>
<ul>
<li>Tahan terhadap gempa hingga 8.5 SR</li>
<li>Dapat dilalui kendaraan hingga 80 km/jam</li>
<li>Dilengkapi jalur khusus sepeda dan pejalan kaki</li>
<li>Sistem monitoring 24 jam</li>
</ul>

<p>Pembangunan jembatan ini menelan biaya sekitar Rp 25 triliun dan melibatkan lebih dari 5.000 pekerja selama 4 tahun. Diharapkan jembatan ini dapat meningkatkan perekonomian Madura hingga 30% dalam 5 tahun ke depan.</p>',
                'excerpt' => 'Presiden Republik Indonesia meresmikan Jembatan Suramadu II yang menjadi jembatan terpanjang di Indonesia dengan panjang mencapai 15.2 kilometer...',
                'category_id' => 1, // Politik
                'author_id' => 3, // Wartawan
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'approved_by' => 2, // Editor
                'approved_at' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'views' => 1680,
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-6 hours')),
            ],
            [
                'title' => 'Film Indonesia Raih Penghargaan di Festival Cannes 2024',
                'slug' => 'film-indonesia-raih-penghargaan-festival-cannes-2024',
                'content' => '<p>Film Indonesia berjudul "Senja di Jakarta" berhasil meraih penghargaan Best Cinematography di Festival Film Cannes 2024. Film yang disutradarai oleh Riri Riza ini menjadi kebanggaan perfilman Indonesia di kancah internasional.</p>

<p>Film yang mengangkat tema kehidupan urban Jakarta ini dibintangi oleh Reza Rahadian, Dian Sastrowardoyo, dan Nicholas Saputra. Cerita film ini berkisah tentang tiga orang yang berbeda latar belakang namun terikat oleh takdir di tengah hiruk pikuk ibu kota.</p>

<p>Sutradara Riri Riza mengungkapkan kegembiraannya atas pencapaian ini. "Ini adalah hasil kerja keras seluruh tim. Kami ingin menunjukkan bahwa sinema Indonesia memiliki kualitas yang tidak kalah dengan film-film dunia," ujarnya.</p>

<p>Penghargaan ini sekaligus membuka jalan bagi film Indonesia untuk lebih dikenal di pasar internasional. Beberapa distributor dari Eropa dan Amerika telah menunjukkan minat untuk mendistribusikan film ini di negara mereka.</p>',
                'excerpt' => 'Film Indonesia berjudul "Senja di Jakarta" berhasil meraih penghargaan Best Cinematography di Festival Film Cannes 2024...',
                'category_id' => 5, // Hiburan
                'author_id' => 3, // Wartawan
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-12 hours')),
                'approved_by' => 2, // Editor
                'approved_at' => date('Y-m-d H:i:s', strtotime('-12 hours')),
                'views' => 750,
                'created_at' => date('Y-m-d H:i:s', strtotime('-14 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-12 hours')),
            ],
            [
                'title' => 'Startup Indonesia Raih Pendanaan Seri B Senilai $50 Juta',
                'slug' => 'startup-indonesia-raih-pendanaan-seri-b-50-juta-dollar',
                'content' => '<p>Startup teknologi finansial asal Indonesia, FinTechNusa, berhasil meraih pendanaan Seri B senilai $50 juta dari konsorsium investor internasional. Pendanaan ini akan digunakan untuk ekspansi ke negara-negara ASEAN lainnya.</p>

<p>CEO FinTechNusa, Budi Santoso, mengatakan bahwa pendanaan ini merupakan validasi terhadap model bisnis yang telah mereka kembangkan selama 5 tahun terakhir. "Kami fokus pada solusi pembayaran digital untuk UMKM di Indonesia," jelasnya.</p>

<p>Investor utama dalam putaran pendanaan ini adalah Sequoia Capital Southeast Asia, Temasek Holdings, dan beberapa family office dari Singapura. Mereka tertarik dengan pertumbuhan pengguna FinTechNusa yang mencapai 300% dalam 2 tahun terakhir.</p>

<p>Dengan pendanaan ini, FinTechNusa menargetkan untuk melayani 10 juta UMKM di Asia Tenggara pada akhir 2025. Mereka juga berencana membuka kantor regional di Singapura dan Bangkok.</p>',
                'excerpt' => 'Startup teknologi finansial asal Indonesia, FinTechNusa, berhasil meraih pendanaan Seri B senilai $50 juta dari konsorsium investor internasional...',
                'category_id' => 4, // Teknologi
                'author_id' => 3, // Wartawan
                'status' => 'pending',
                'published_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'views' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ]
        ];

        $this->db->table('news')->insertBatch($data);
    }
}
