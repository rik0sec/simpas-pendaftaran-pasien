<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama', 'email', 'password', 'no_hp', 'foto', 'role', 'created_at'];

    // created_at pakai default CURRENT_TIMESTAMP dari MySQL, jadi
    // useTimestamps CI4 tidak diaktifkan supaya tidak konflik
    protected $useTimestamps = false;

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}