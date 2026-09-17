<?php

namespace App\Controllers;



class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'judul' => 'Halaman Dashboard',
        ];

        return view('dashboard/index', $data);
    }

    public function logout()
    {
        session()->remove([
            'isLoggedIn',
            'user_id',
            'role'
        ]);

        session()->setFlashdata('success', 'Anda berhasil logout');

        return redirect()
            ->to('/');
    }
}
