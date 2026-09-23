<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;

class BarangController extends BaseController
{
    // Variabel model yang akan menangani tabel barang
    protected $barangModel;

    // Selalu mendeklarasikan model barang di awal sehingga setiap method dapat memanggil fungsi model barang
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
        // Aturan validasi tabel barang
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
                        'greater_than_equal_to' => 'Jumlah barang tidak boleh kurang dari 0!'
                    ]
                ],
                'gambar' => [
                    'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
                    'errors' => [
                        'is_image' => 'File yang anda pilih bukan gambar!',
                        'mime_in' => 'Format file harus JPG, JPEG, atau PNG!',
                        'max_size' => 'Ukuran gambar maksimal 2 MB!'
                    ]
                ]
            ]
        )) {
            // Feedback yang akan dikirim ke javascript jika ditemukan error saat validasi value form tambah barang
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Variabel untuk menampung nama file gambar barang
        $namaBaru = 'default.png';
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaBaru = $file->getRandomName();

            $file->move(FCPATH . 'img', $namaBaru);
        }

        // Data yang akan diisikan ke database
        // Sesuaikan nama kolom yang akan diisi di database (kiri) dengan value yang didapat dari form (kanan)
        $data = [
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'kategori'      => $this->request->getPost('kategori'),
            'jumlah'        => $this->request->getPost('jumlah'),
            'gambar'        => $namaBaru
        ];

        // Simpan data barang ke database
        $this->barangModel->save($data);

        // Feedback di kirim ke javascript
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    // Method untuk menemukan data barang mana yang akan di edit
    public function getBarang($id)
    {
        // Temukan data barag dari database menggunakan parameter id barang
        $barang = $this->barangModel->find($id);

        // Feedback ke javascript jika barang tidak ditemukan di database
        if (!$barang) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Data barang tidak ditemukan!'
            ]);
        }

        // Feedback jika berhasil menemukan barang di database
        return $this->response->setJSON([
            'status' => true,
            'data' => $barang
        ]);
    }

    // Method untuk meyimpan data ke dalam database setelah dilakukan perubahan pada data barang
    public function ubahData($id)
    {
        // Temukan data barang berdasarkan parameter id untuk dijadikan sebagai pembanding dalam melakukan validasi data
        $barang = $this->barangModel->find($id);

        // Aturan validasi data barang setelah dilakukan perubahan data barang
        $rule = '';
        $barang = $this->barangModel->find($id);

        // Karena ada rule is_unique ketika membuat data barang nama barang tidak boleh sama
        // Sedangkan pada proses edit kadang kita tidak mengubah nama barang hal ini akan mengakibatkan error
        // Maka buat 2 rule yang berbeda. Jika nama barang yang di kirim melalui form sudah ada di database barang rule is_unique dihapus
        if ($this->request->getVar('nama_barang') == $barang['nama_barang']) {
            $rule = 'required|max_length[255]';
        } else {
            $rule = 'required|max_length[255]|is_unique[barang.nama_barang]';
        }

        // Aturan validasi barang yang akan diubah
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
                        'greater_than_equal_to' => 'Jumlah barang tidak boleh kurang dari 0!'
                    ]
                ],
                'gambar' => [
                    'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar, 2048]',
                    'errors' => [
                        'is_image' => 'File yang anda pilih bukan gambar!',
                        'mime_in' => 'Format file harus JPG, JPEG, atau PNG!',
                        'max_size' => 'Ukuran gambar maksimal 2 MB!'
                    ]
                ]
            ]
        )) {
            // Feedback ke javascript jika ditemukan error pada validasi form ubah barang
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Data yang akan diisikan ke database
        // Sesuaikan nama kolom yang akan diisi di database (kiri) dengan value yang didapat dari form (kanan)
        $data = [
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'kategori'      => $this->request->getPost('kategori'),
            'jumlah'        => $this->request->getPost('jumlah'),
            'gambar'        => ''
        ];

        // Simpan perubahan
        $this->barangModel->update($id, $data);

        // Feedback ke javascript karena data telah berhasil diubah dan disimpan ke database
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function hapusBarang($id)
    {
        // Temukan data  barang yang ingin dihapus berdasarkan parameter id
        $barang = $this->barangModel->find($id);

        // Feedback jika barang tidak ditemukan di dalam database
        if (!$barang) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'    => false,
                'message'   => 'Data barang tidak ditemukan.'
            ]);
        }

        // Jika ditemukan. Hapus data barang
        $this->barangModel->delete($id);

        // Feedback ke javascript karena data berhasil dihapus dari database
        return $this->response->setJSON([
            'status'        => true,
            'message'       => 'Data berhasil di hapus.'
        ]);
    }
}
