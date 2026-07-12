<?php

namespace App\Controllers;

use App\Models\PasienModel;

class Pasien extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Pasien',
            'pasien' => $this->pasienModel->orderBy('id_pasien', 'DESC')->findAll(),
        ];

        return view('pasien/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Tambah Pasien',
            'no_rm_baru' => $this->pasienModel->generateNoRm(),
        ];

        return view('pasien/create', $data);
    }

    public function store()
    {
        $rules = [
            'nik'           => 'required|min_length[16]|max_length[20]|is_unique[pasien.nik]',
            'nama'          => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tanggal_lahir' => 'required|valid_date',
            'no_hp'         => 'permit_empty|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pasienModel->insert([
            'no_rm'         => $this->pasienModel->generateNoRm(),
            'nik'           => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/pasien')->with('message', 'Data pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasien = $this->pasienModel->find($id);

        if (! $pasien) {
            return redirect()->to('/pasien')->with('error', 'Data pasien tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Pasien',
            'pasien' => $pasien,
        ];

        return view('pasien/edit', $data);
    }

    public function update($id)
    {
        $pasien = $this->pasienModel->find($id);

        if (! $pasien) {
            return redirect()->to('/pasien')->with('error', 'Data pasien tidak ditemukan.');
        }

        $rules = [
            'nik'           => "required|min_length[16]|max_length[20]|is_unique[pasien.nik,id_pasien,{$id}]",
            'nama'          => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tanggal_lahir' => 'required|valid_date',
            'no_hp'         => 'permit_empty|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pasienModel->update($id, [
            'nik'           => $this->request->getPost('nik'),
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/pasien')->with('message', 'Data pasien berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pasien = $this->pasienModel->find($id);

        if (! $pasien) {
            return redirect()->to('/pasien')->with('error', 'Data pasien tidak ditemukan.');
        }

        $this->pasienModel->delete($id);

        return redirect()->to('/pasien')->with('message', 'Data pasien berhasil dihapus.');
    }
}
