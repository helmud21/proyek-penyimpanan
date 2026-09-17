<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Halaman Login',
            'validation' => \Config\Services::validation()
        ];

        return view('login/index', $data);
    }

    public function login()
    {
        //validasi email dan password
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email tidak boleh kosong',
                    'valid_email' => 'Harap isi dengan email yang valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong',
                ]
            ]
        ])) {

            return redirect()->back()->withInput();
        }

        //deklarasi model user
        $userModel = new UserModel();

        //temukan user yang sesuai di dalam database berdasarkan email user
        $user = $userModel->where('email', $this->request->getVar('email'))->first();

        //jika email yang digunakan untuk login ditemukan verifikasi password
        if (password_verify($this->request->getVar('password'), $user['password'])) {
            //set session
            session()->regenerate();

            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $user['id'],
                'role'       => $user['role'],
            ]);
            //jika password valid periksa role user dan arahkan ke halaman dashboard yang sesuai
            if ($user['role'] == 'admin') {
                return redirect()->to('/dashboard')->withInput();
            } else {
                return redirect()->to('/dashboard/ceo')->withInput();
            }
        }

        return redirect()->back()->withInput()->with('error', 'Email atau password yang anda masukkan salah');
    }
}
