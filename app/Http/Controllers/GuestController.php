<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GuestController extends Controller
{
    protected $api_key;

    public function __construct()
    {
        $this->api_key = config('openweather.api_key');
    }

    public function index()
    {
        return view('beranda');
    }

    public function informasi()
    {
        return view('informasi');
    }

    public function layanan()
    {
        return view('layanan');
    }

    public function cuaca()
    {
        $kota = 'Sambas';
        $labelKota = 'Sambas, Kalimantan Barat';

        // 1. Hit API Cuaca Hari Ini
        $responseHariIni = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $kota,
            'appid' => $this->api_key,
            'units' => 'metric',
            'lang' => 'id',
        ]);

        // 2. Hit API Forecast 5 Hari
        $responseForecast = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => $kota,
            'appid' => $this->api_key,
            'units' => 'metric',
            'lang' => 'id',
        ]);

        $dataCuaca = $responseHariIni->successful() ? $responseHariIni->json() : null;
        $prakiraanCuaca = [];
        $rekomendasiTani = [
            'pemupukan' => ['status' => 'Aman', 'warna' => 'success', 'pesan' => 'Kondisi optimal untuk penyerapan pupuk.'],
            'penyemprotan' => ['status' => 'Aman', 'warna' => 'success', 'pesan' => 'Angin stabil, pestisida tidak akan terbuang.'],
            'pemanenan' => ['status' => 'Aman', 'warna' => 'success', 'pesan' => 'Cuaca mendukung untuk menjaga kualitas hasil panen.'],
            'risiko_penyakit' => ['tingkat' => 'Rendah', 'warna' => 'success', 'pesan' => 'Kelembaban udara dalam batas normal.'],
            'irigasi' => ['status' => 'Tunda', 'warna' => 'warning', 'pesan' => 'Kelembaban tanah masih memadai. Tunda irigasi tambahan hingga 2 hari ke depan.'],
            'panen' => ['status' => 'Aman', 'warna' => 'success', 'pesan' => 'Cuaca mendukung aktivitas panen. Lakukan pagi hari.'],
        ];

        // ==================== LOGIKA KOMPLEKS ANALISIS AGRO-KLIMATOLOGI ====================
        if ($dataCuaca) {
            $kelembaban = $dataCuaca['main']['humidity'] ?? 0;
            $kecepatanAngin = $dataCuaca['wind']['speed'] ?? 0; // m/s
            $kondisiLangit = strtolower($dataCuaca['weather'][0]['main'] ?? '');
            $curahHujanTercatat = isset($dataCuaca['rain']['1h']) ? $dataCuaca['rain']['1h'] : 0;

            // A. Analisis Kelayakan Penyemprotan Pestisida (Sangat dipengaruhi angin & hujan)
            if ($kecepatanAngin > 5.5) { // Lebih dari ~20 km/jam
                $rekomendasiTani['penyemprotan'] = [
                    'status' => 'Tunda', 'warna' => 'error',
                    'pesan' => 'Angin terlalu kencang (> 5.5 m/s). Risiko drift (pestisida terbang terbawa angin) sangat tinggi.',
                ];
            } elseif ($kondisiLangit === 'rain' || $curahHujanTercatat > 0) {
                $rekomendasiTani['penyemprotan'] = [
                    'status' => 'Bahaya', 'warna' => 'error',
                    'pesan' => 'Sedang hujan. Pestisida akan langsung luntur terbilas air hujan sebelum diserap tanaman.',
                ];
            }

            // B. Analisis Kelayakan Pemupukan (Membutuhkan tanah lembab tapi tidak tergenang hujan lebat)
            if ($kondisiLangit === 'rain' && $curahHujanTercatat > 2.5) {
                $rekomendasiTani['pemupukan'] = [
                    'status' => 'Tunda', 'warna' => 'warning',
                    'pesan' => 'Hujan lebat terdeteksi. Risiko pupuk hanyut terbawa aliran permukaan (run-off).',
                ];
            } elseif ($kelembaban < 40) {
                $rekomendasiTani['pemupukan'] = [
                    'status' => 'Kurang Ideal', 'warna' => 'warning',
                    'pesan' => 'Udara terlalu kering. Lakukan penyiraman lahan terlebih dahulu sebelum memupuk.',
                ];
            }

            // C. Analisis Risiko Inkubasi Jamur & Hama (Kelembaban tinggi + Suhu hangat khas Kalbar)
            if ($kelembaban > 85) {
                $rekomendasiTani['risiko_penyakit'] = [
                    'tingkat' => 'Tinggi', 'warna' => 'error',
                    'pesan' => 'Kelembaban ekstrem (>85%). Sangat rawan inkubasi Jamur Karat Daun dan Blast Padi. Tingkatkan kewaspadaan!',
                ];
            } elseif ($kelembaban > 70) {
                $rekomendasiTani['risiko_penyakit'] = [
                    'tingkat' => 'Sedang', 'warna' => 'warning',
                    'pesan' => 'Kondisi lembab, disukai oleh perkembangan koloni Wereng Coklat.',
                ];
            }
        }

        // ==================== LOGIKA KOMPLEKS PENGELOMPOKAN FORECAST ====================
        if ($responseForecast->successful()) {
            $listForecast = $responseForecast->json()['list'];
            $grouped = [];

            // Kelompokkan data berdasarkan tanggal murni (YYYY-MM-DD)
            foreach ($listForecast as $item) {
                $tanggal = substr($item['dt_txt'], 0, 10);
                $grouped[$tanggal][] = $item;
            }

            // Ekstrak nilai statistik terbaik dari setiap hari untuk kebutuhan visual petani
            $counter = 0;
            foreach ($grouped as $tanggal => $items) {
                if ($counter >= 5) {
                    break;
                } // Ambil 5 hari saja

                // Cari sampel jam siang (dekat ke jam 12:00) untuk mewakili ikon cuaca harian
                $sampelSiang = $items[array_key_first($items)];
                foreach ($items as $it) {
                    if (str_contains($it['dt_txt'], '12:00:00')) {
                        $sampelSiang = $it;
                        break;
                    }
                }

                // Hitung Max & Min suhu asli di hari tersebut
                $temps = array_column(array_column($items, 'main'), 'temp');

                $prakiraanCuaca[] = [
                    'tanggal' => $tanggal,
                    'temp_max' => max($temps),
                    'temp_min' => min($temps),
                    'icon' => $sampelSiang['weather'][0]['icon'],
                    'deskripsi' => $sampelSiang['weather'][0]['description'],
                ];
                $counter++;
            }
        }

        return view('cuaca', compact('dataCuaca', 'prakiraanCuaca', 'rekomendasiTani', 'labelKota'));
    }
}
