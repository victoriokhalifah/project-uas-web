<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('role');
        
        if (!$userRole) {
            return redirect()->to('/auth/login');
        }
        
        // Check role permissions
        if ($arguments && !in_array($userRole, $arguments)) {
            return redirect()->to('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
