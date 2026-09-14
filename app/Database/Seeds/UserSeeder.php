<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama' => 'Helmud Panggabean',
                'email' => 'helmudgabe@gmail.com',
                'password' => password_hash('dragonkick', PASSWORD_DEFAULT),
                'role' => 'ceo',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ]
        ];

        $this->db->table('user')->insertBatch($data);
    }
}
