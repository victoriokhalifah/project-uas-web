<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check remember token if not logged in
        if (!$session->get('logged_in') && isset($_COOKIE['remember_token'])) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->where('remember_token', $_COOKIE['remember_token'])->first();
            
            if ($user && $user['is_active'] == 1) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar'],
                    'logged_in' => true
                ];
                $session->set($sessionData);
            }
        }
        
        // Check if user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
