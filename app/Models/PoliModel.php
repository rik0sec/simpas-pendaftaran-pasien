<?php

namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table         = 'poli';
    protected $primaryKey    = 'id_poli';
    protected $allowedFields = ['nama_poli', 'lokasi'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'nama_poli' => 'required|min_length[3]',
    ];
}
