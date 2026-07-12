<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PoliModel;

class Pendaftaran extends BaseController
{
    protected $pendaftaranModel;
    protected $pasienModel;
    protected $dokterModel;
    protected $poliModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel      = new PasienModel();
        $this->dokterModel      = new DokterModel();
        $this->poliModel        = new PoliModel();
    }

    public function index()
    {
        $data = [
            'title'       => 'Data Pendaftaran',
            'pendaftaran' => $this->pendaftaranModel->getPendaftaranLengkap(),
        ];

        return view('pendaftaran/index', $data);
    }

    public function create()
    {
        $data = [
            'title'  => 'Daftarkan Pasien',
            'pasien' => $this->pasienModel->orderBy('nama', 'ASC')->findAll(),
            'dokter' => $this->dokterModel->orderBy('nama_dokter', 'ASC')->findAll(),
            'poli'   => $this->poliModel->orderBy('nama_poli', 'ASC')->findAll(),
        ];

        return view('pendaftaran/create', $data);
    }

    public function store()
    {
        $rules = [
            'id_pasien'      => 'required|numeric',
            'id_dokter'      => 'required|numeric',
            'id_poli'        => 'required|numeric',
            'tanggal_daftar' => 'required|valid_date',
            'keluhan'        => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idPoli   = (int) $this->request->getPost('id_poli');
        $tanggal  = $this->request->getPost('tanggal_daftar');
        $noAntrian = $this->pendaftaranModel->generateNoAntrian($tanggal, $idPoli);

        $this->pendaftaranModel->insert([
            'id_pasien'      => $this->request->getPost('id_pasien'),
            'id_dokter'      => $this->request->getPost('id_dokter'),
            'id_poli'        => $idPoli,
            'tanggal_daftar' => $tanggal,
            'no_antrian'     => $noAntrian,
            'keluhan'        => $this->request->getPost('keluhan'),
            'status'         => 'Menunggu',
        ]);

        return redirect()->to('/pendaftaran')
            ->with('message', "Pendaftaran berhasil. Nomor antrian: {$noAntrian}");
    }

    public function edit($id)
    {
        $pendaftaran = $this->pendaftaranModel->find($id);

        if (! $pendaftaran) {
            return redirect()->to('/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $data = [
            'title'       => 'Edit Pendaftaran',
            'pendaftaran' => $pendaftaran,
            'pasien'      => $this->pasienModel->orderBy('nama', 'ASC')->findAll(),
            'dokter'      => $this->dokterModel->orderBy('nama_dokter', 'ASC')->findAll(),
            'poli'        => $this->poliModel->orderBy('nama_poli', 'ASC')->findAll(),
        ];

        return view('pendaftaran/edit', $data);
    }

    public function update($id)
    {
        $pendaftaran = $this->pendaftaranModel->find($id);

        if (! $pendaftaran) {
            return redirect()->to('/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $rules = [
            'id_pasien'      => 'required|numeric',
            'id_dokter'      => 'required|numeric',
            'id_poli'        => 'required|numeric',
            'tanggal_daftar' => 'required|valid_date',
            'status'         => 'required|in_list[Menunggu,Selesai]',
            'keluhan'        => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pendaftaranModel->update($id, [
            'id_pasien'      => $this->request->getPost('id_pasien'),
            'id_dokter'      => $this->request->getPost('id_dokter'),
            'id_poli'        => $this->request->getPost('id_poli'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
            'keluhan'        => $this->request->getPost('keluhan'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to('/pendaftaran')->with('message', 'Data pendaftaran berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pendaftaran = $this->pendaftaranModel->find($id);

        if (! $pendaftaran) {
            return redirect()->to('/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $this->pendaftaranModel->delete($id);

        return redirect()->to('/pendaftaran')->with('message', 'Data pendaftaran berhasil dihapus.');
    }
}
