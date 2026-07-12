<?php

namespace App\Controllers;

use App\Models\PoliModel;

class Poli extends BaseController
{
    protected $poliModel;

    public function __construct()
    {
        $this->poliModel = new PoliModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Poli',
            'poli'  => $this->poliModel->orderBy('id_poli', 'DESC')->findAll(),
        ];

        return view('poli/index', $data);
    }

    public function create()
    {
        return view('poli/create', ['title' => 'Tambah Poli']);
    }

    public function store()
    {
        $rules = [
            'nama_poli' => 'required|min_length[3]',
            'lokasi'    => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->poliModel->insert([
            'nama_poli' => $this->request->getPost('nama_poli'),
            'lokasi'    => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/poli')->with('message', 'Data poli berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $poli = $this->poliModel->find($id);

        if (! $poli) {
            return redirect()->to('/poli')->with('error', 'Data poli tidak ditemukan.');
        }

        return view('poli/edit', ['title' => 'Edit Poli', 'poli' => $poli]);
    }

    public function update($id)
    {
        $poli = $this->poliModel->find($id);

        if (! $poli) {
            return redirect()->to('/poli')->with('error', 'Data poli tidak ditemukan.');
        }

        $rules = [
            'nama_poli' => 'required|min_length[3]',
            'lokasi'    => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->poliModel->update($id, [
            'nama_poli' => $this->request->getPost('nama_poli'),
            'lokasi'    => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/poli')->with('message', 'Data poli berhasil diperbarui.');
    }

    public function delete($id)
    {
        $poli = $this->poliModel->find($id);

        if (! $poli) {
            return redirect()->to('/poli')->with('error', 'Data poli tidak ditemukan.');
        }

        $this->poliModel->delete($id);

        return redirect()->to('/poli')->with('message', 'Data poli berhasil dihapus.');
    }
}
