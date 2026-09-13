<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index(): string
    {
        $data = [
            'judul' => 'Halaman Login'
        ];

        return view('login/index.php', $data);
    }
}
