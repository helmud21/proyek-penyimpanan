<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;

class BarangController extends BaseController
{
    protected $barangModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        //Ambil semua data barang dari database ke dalam variabel data
        $data = $this->barangModel->findAll();

        //Kirimkan ke javascript dalam format JSON untuk ditampilkan di datatables
        return $this->response->setJSON($data);
    }

    public function create()
    {
        if (!$this->validate(
            [
                'nama_barang' => [
                    'rules' => 'required|max_length[255]|is_unique[barang.nama_barang]',
                    'errors' => [
                        'required' => 'Nama barang wajib diisi!',
                        'max_length' => 'Nama barang terlalu panjang!',
                        'is_unique' => 'Barang sudah terdaftar!'
                    ]
                ],
                'kategori' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Kategori harus diisi!',
                        'max_length' => 'Nama kategori terlalu panjang!'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required|integer|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Jumlah barang harus diisi!',
                        'integer' => 'Yang anda masukkan bukan angka!',
                        'greater_than_equal_to' => 'Jumlah barang minimal 1!'
                    ]
                ]
            ]
        )) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'kategori'      => $this->request->getPost('kategori'),
            'jumlah'        => $this->request->getPost('jumlah')
        ];

        $this->barangModel->save($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    public function getBarang($id)
    {

        $barang = $this->barangModel->find($id);

        if (!$barang) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Data barang tidak ditemukan!'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $barang
        ]);
    }

    public function ubahData($id)
    {
        $barang = $this->barangModel->find($id);
        // var_dump($barang);

        $rule = '';
        $barang = $this->barangModel->find($id);
        if ($this->request->getVar('nama_barang') == $barang['nama_barang']) {
            $rule = 'required|max_length[255]';
        } else {
            $rule = 'required|max_length[255]|is_unique[barang.nama_barang]';
        }

        if (!$this->validate(
            [
                'nama_barang' => [
                    'rules' => $rule,
                    'errors' => [
                        'required' => 'Nama barang wajib diisi!',
                        'max_length' => 'Nama barang terlalu panjang!',
                        'is_unique' => 'Barang sudah terdaftar!'
                    ]
                ],
                'kategori' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Kategori harus diisi!',
                        'max_length' => 'Nama kategori terlalu panjang!'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required|integer|greater_than_equal_to[0]',
                    'errors' => [
                        'required' => 'Jumlah barang harus diisi!',
                        'integer' => 'Yang anda masukkan bukan angka!',
                        'greater_than_equal_to' => 'Jumlah barang minimal 1!'
                    ]
                ]
            ]
        )) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'kategori'      => $this->request->getPost('kategori'),
            'jumlah'        => $this->request->getPost('jumlah')
        ];

        $this->barangModel->update($id, $data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function hapusBarang($id)
    {
        $barang = $this->barangModel->find($id);

        if (!$barang) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'    => false,
                'message'   => 'Data barang tidak ditemukan.'
            ]);
        }

        $this->barangModel->delete($id);

        return $this->response->setJSON([
            'status'        => true,
            'message'       => 'Data berhasil di hapus.'
        ]);
    }
}
