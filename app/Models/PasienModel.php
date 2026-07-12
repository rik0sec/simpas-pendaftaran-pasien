<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table         = 'pasien';
    protected $primaryKey    = 'id_pasien';
    protected $allowedFields = [
        'no_rm', 'nik', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_hp',
    ];
    protected $useTimestamps = false;

    protected $validationRules = [
        'no_rm'         => 'required|is_unique[pasien.no_rm,id_pasien,{id_pasien}]',
        'nik'           => 'required|min_length[16]|max_length[20]|is_unique[pasien.nik,id_pasien,{id_pasien}]',
        'nama'          => 'required|min_length[3]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'tanggal_lahir' => 'required|valid_date',
    ];

    // Bikin nomor RM otomatis, contoh: RM0001, RM0002, dst.
    public function generateNoRm(): string
    {
        $last = $this->selectMax('id_pasien')->first();
        $nextId = ($last['id_pasien'] ?? 0) + 1;

        return 'RM' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
