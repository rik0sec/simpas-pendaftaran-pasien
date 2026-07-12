<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laporan extends Controller
{
    public function index()
    {
        $db = db_connect();

        // ---------- Ambil filter dari form (GET) ----------
        $mulai = $this->request->getGet('mulai') ?: date('Y-m-01'); // default: awal bulan ini
        $akhir = $this->request->getGet('akhir') ?: date('Y-m-d');  // default: hari ini
        $poliId = $this->request->getGet('poli') ?: '';

        // ---------- Query utama (sesuai struktur tabel asli) ----------
        $builder = $db->table('pendaftaran p')
            ->select('
                p.tanggal_daftar,
                p.no_antrian,
                pas.no_rm,
                pas.nama AS nama_pasien,
                po.nama_poli AS poli,
                dok.nama_dokter AS dokter,
                p.status
            ')
            ->join('pasien pas', 'pas.id_pasien = p.id_pasien')
            ->join('poli po', 'po.id_poli = p.id_poli')
            ->join('dokter dok', 'dok.id_dokter = p.id_dokter')
            ->where('p.tanggal_daftar >=', $mulai)
            ->where('p.tanggal_daftar <=', $akhir)
            ->orderBy('p.tanggal_daftar', 'DESC');

        if (!empty($poliId)) {
            $builder->where('p.id_poli', $poliId);
        }

        $dataLaporan = $builder->get()->getResultArray();

        // ---------- Class badge status untuk styling ----------
        // Status di tabel cuma ada: 'Menunggu' dan 'Selesai'
        foreach ($dataLaporan as &$row) {
            $row['status_class'] = ($row['status'] === 'Selesai') ? 'selesai' : 'proses';
        }

        // ---------- Ringkasan angka ----------
        $totalPendaftaran = count($dataLaporan);
        $totalSelesai  = count(array_filter($dataLaporan, fn($r) => $r['status'] === 'Selesai'));
        $totalMenunggu = count(array_filter($dataLaporan, fn($r) => $r['status'] === 'Menunggu'));

        // ---------- List poli untuk dropdown filter ----------
        $listPoli = $db->table('poli')->select('id_poli AS id, nama_poli')->get()->getResultArray();

        return view('laporan/index', [
            'dataLaporan'      => $dataLaporan,
            'tanggalMulai'     => $mulai,
            'tanggalAkhir'     => $akhir,
            'listPoli'         => $listPoli,
            'totalPendaftaran' => $totalPendaftaran,
            'totalSelesai'     => $totalSelesai,
            'totalMenunggu'    => $totalMenunggu,
        ]);
    }
}