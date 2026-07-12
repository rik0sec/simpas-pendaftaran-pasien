<?php

namespace App\Controllers;

use App\Models\DokterModel;

class Dokter extends BaseController
{
    protected $dokterModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Dokter',
            'dokter' => $this->dokterModel->orderBy('id_dokter', 'DESC')->findAll(),
        ];

        return view('dokter/index', $data);
    }

    public function create()
    {
        return view('dokter/create', ['title' => 'Tambah Dokter']);
    }

    public function store()
    {
        $rules = [
            'nama_dokter' => 'required|min_length[3]',
            'spesialis'   => 'required',
            'no_hp'       => 'permit_empty|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->dokterModel->insert([
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'spesialis'   => $this->request->getPost('spesialis'),
            'no_hp'       => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/dokter')->with('message', 'Data dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = $this->dokterModel->find($id);

        if (! $dokter) {
            return redirect()->to('/dokter')->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('dokter/edit', ['title' => 'Edit Dokter', 'dokter' => $dokter]);
    }

    public function update($id)
    {
        $dokter = $this->dokterModel->find($id);

        if (! $dokter) {
            return redirect()->to('/dokter')->with('error', 'Data dokter tidak ditemukan.');
        }

        $rules = [
            'nama_dokter' => 'required|min_length[3]',
            'spesialis'   => 'required',
            'no_hp'       => 'permit_empty|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->dokterModel->update($id, [
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'spesialis'   => $this->request->getPost('spesialis'),
            'no_hp'       => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/dokter')->with('message', 'Data dokter berhasil diperbarui.');
    }

    public function delete($id)
    {
        $dokter = $this->dokterModel->find($id);

        if (! $dokter) {
            return redirect()->to('/dokter')->with('error', 'Data dokter tidak ditemukan.');
        }

        $this->dokterModel->delete($id);

        return redirect()->to('/dokter')->with('message', 'Data dokter berhasil dihapus.');
    }
}
