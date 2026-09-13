<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'judul' => 'Halaman Dashboard'
        ];

        return view('dashboard/index', $data);
    }
}
