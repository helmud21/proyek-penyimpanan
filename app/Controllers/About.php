<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index(): string
    {
        $data = [
            'judul' => 'About Us'
        ];

        return view('about/index', $data);
    }
}
