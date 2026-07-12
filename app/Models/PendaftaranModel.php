<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table         = 'pendaftaran';
    protected $primaryKey    = 'id_daftar';
    protected $allowedFields = [
        'id_pasien', 'id_dokter', 'id_poli', 'tanggal_daftar',
        'no_antrian', 'keluhan', 'status',
    ];
    protected $useTimestamps = false;

    protected $validationRules = [
        'id_pasien'      => 'required|numeric',
        'id_dokter'      => 'required|numeric',
        'id_poli'        => 'required|numeric',
        'tanggal_daftar' => 'required|valid_date',
    ];

    // Ambil data pendaftaran lengkap dengan JOIN ke pasien, dokter, poli
    public function getPendaftaranLengkap()
    {
        return $this->select(
                'pendaftaran.*, pasien.nama as nama_pasien, pasien.no_rm, ' .
                'dokter.nama_dokter, poli.nama_poli'
            )
            ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
            ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
            ->orderBy('pendaftaran.tanggal_daftar', 'DESC')
            ->orderBy('pendaftaran.no_antrian', 'ASC')
            ->findAll();
    }

    // Hitung nomor antrian otomatis, reset per hari per poli
    public function generateNoAntrian(string $tanggal, int $idPoli): int
    {
        $last = $this->selectMax('no_antrian')
            ->where('tanggal_daftar', $tanggal)
            ->where('id_poli', $idPoli)
            ->first();

        return ($last['no_antrian'] ?? 0) + 1;
    }
}
