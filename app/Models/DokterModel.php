<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table         = 'dokter';
    protected $primaryKey    = 'id_dokter';
    protected $allowedFields = ['nama_dokter', 'spesialis', 'no_hp'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'nama_dokter' => 'required|min_length[3]',
        'spesialis'   => 'required',
    ];
}
