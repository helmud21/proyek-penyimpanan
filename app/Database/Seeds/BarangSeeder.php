<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_barang'   => 'Asus',
                'kategori'      => 'Elektronik',
                'jumlah'        => 50,
                'gambar'        => 'default.png',
                'created_at' => Time::now(),
                'updated_at' => Time::now()

            ],
            [
                'nama_barang'   => 'Tas Gucci',
                'kategori'      => 'Aksesoris',
                'jumlah'        => 50,
                'gambar'        => 'default.png',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama_barang'   => 'Pakaian Billabong',
                'kategori'      => 'Fashion',
                'jumlah'        => 100,
                'gambar'        => 'default.png',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ]
        ];

        $this->db->table('barang')->insertBatch($data);
    }
}
