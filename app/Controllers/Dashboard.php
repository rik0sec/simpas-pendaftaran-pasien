<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PoliModel;
use App\Models\PendaftaranModel;

class Dashboard extends BaseController
{
    protected $pasienModel;
    protected $dokterModel;
    protected $poliModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->pasienModel      = new PasienModel();
        $this->dokterModel      = new DokterModel();
        $this->poliModel        = new PoliModel();
        $this->pendaftaranModel = new PendaftaranModel();
    }

    public function index()
    {
        // ------- Ganti nama kolom tanggal di bawah ini kalau berbeda -------
        // Asumsi: tabel `pendaftaran` punya kolom `tanggal` (format Y-m-d)
        $kolomTanggal = 'tanggal_daftar';

        $data['total_pasien']         = $this->pasienModel->countAll();
        $data['total_dokter']         = $this->dokterModel->countAll();
        $data['total_poli']           = $this->poliModel->countAll();
        $data['pendaftaran_hari_ini'] = $this->pendaftaranModel
            ->where($kolomTanggal, date('Y-m-d'))
            ->countAllResults();

        // ------- Data tren 14 hari terakhir -------
        $labels = [];
        $counts = [];

        for ($i = 13; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i day"));

            $jumlah = $this->pendaftaranModel
                ->where($kolomTanggal, $tanggal)
                ->countAllResults();

            $labels[] = date('d M', strtotime($tanggal));
            $counts[] = $jumlah;
        }

        $data['chart_labels'] = $labels;
        $data['chart_data']   = $counts;

        // Jumlah pasien yang masih berstatus "Menunggu" (kolom status: enum Menunggu/Selesai)
        $data['pasien_menunggu'] = $this->pendaftaranModel
            ->where('status', 'Menunggu')
            ->countAllResults();

        return view('dashboard/index', $data);
    }
}