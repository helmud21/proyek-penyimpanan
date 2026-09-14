<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil role user dari session
        $userRole = session()->get('role');

        // Role yang diizinkan dikirim melalui argument route
        $allowedRoles = $arguments ?? [];

        // Jika role user tidak termasuk role yang diizinkan
        if (!in_array($userRole, $allowedRoles, true)) {
            return redirect()
                ->to('/dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses setelah controller
    }
}
