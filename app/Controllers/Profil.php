<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan halaman profil user yang sedang login
     */
    public function index()
    {
        $userId = session()->get('id'); // sesuai key session di Auth::login()

        $data['user'] = $this->userModel->find($userId);

        return view('profil/index', $data);
    }

    /**
     * Update informasi dasar akun (nama, email, no_hp, foto)
     */
    public function update()
    {
        $userId = session()->get('id');

        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $dataUpdate = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp'  => $this->request->getPost('no_hp'),
        ];

        // Upload foto profil kalau ada file baru
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/foto_profil', $namaFoto);
            $dataUpdate['foto'] = $namaFoto;
        }

        $this->userModel->update($userId, $dataUpdate);

        // Sinkronkan nama di session (dipakai di topbar) setelah update
        session()->set(['nama' => $dataUpdate['nama']]);

        return redirect()->to('profil')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password user
     */
    public function updatePassword()
    {
        $userId = session()->get('id');
        $user   = $this->userModel->find($userId);
        $passwordLama        = $this->request->getPost('password_lama');
        $passwordBaru        = $this->request->getPost('password_baru');
        $passwordKonfirmasi  = $this->request->getPost('password_konfirmasi');

        if (! password_verify($passwordLama, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }

        if ($passwordBaru !== $passwordKonfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
        }

        if (strlen($passwordBaru) < 8) {
            return redirect()->back()->with('error', 'Password baru minimal 8 karakter.');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('profil')->with('success', 'Password berhasil diperbarui. Silakan gunakan password baru saat login berikutnya.');
    }
}