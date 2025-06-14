<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;
    protected $session;
    protected $email;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        $this->email = \Config\Services::email();
        helper(['form', 'url']);
    }

    public function login()
    {
        // Check remember token first
        $this->checkRememberToken();
        
        if ($this->session->get('user_id')) {
            return redirect()->to('/admin/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'login' => 'required',
                'password' => 'required'
            ];

            if (!$this->validate($rules)) {
                return view('auth/login', [
                    'validation' => $this->validator,
                    'title' => 'Login'
                ]);
            }

            $login = $this->request->getPost('login');
            $password = $this->request->getPost('password');
            $remember = $this->request->getPost('remember');

            // Find user by email or username
            $user = $this->userModel->findByEmail($login);
            if (!$user) {
                $user = $this->userModel->findByUsername($login);
            }

            if ($user && password_verify($password, $user['password'])) {
                if ($user['is_active'] == 0) {
                    $this->session->setFlashdata('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                    return view('auth/login', ['title' => 'Login']);
                }

                // Set session
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar'],
                    'logged_in' => true
                ];
                $this->session->set($sessionData);

                // Handle remember me
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $this->userModel->update($user['id'], ['remember_token' => $token]);
                    
                    // Set cookie for 30 days
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
                }

                $this->session->setFlashdata('success', 'Login berhasil! Selamat datang, ' . $user['full_name']);
                return redirect()->to('/admin/dashboard');
            } else {
                $this->session->setFlashdata('error', 'Email/Username atau password salah.');
            }
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function register()
    {
        if ($this->session->get('user_id')) {
            return redirect()->to('/admin/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                'full_name' => 'required|min_length[3]|max_length[255]'
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', [
                    'validation' => $this->validator,
                    'title' => 'Register'
                ]);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'full_name' => $this->request->getPost('full_name'),
                'role' => 'wartawan', // Default role
                'is_active' => 1
            ];

            if ($this->userModel->insert($data)) {
                $this->session->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
                return redirect()->to('/auth/login');
            } else {
                $this->session->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            }
        }

        return view('auth/register', ['title' => 'Register']);
    }

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $user = $this->userModel->findByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->userModel->updateResetToken($user['id'], $token, $expires);

                // Send email (simplified - you should use proper email template)
                $resetLink = base_url('auth/reset-password/' . $token);
                $message = "Klik link berikut untuk reset password: " . $resetLink;

                $this->email->setTo($email);
                $this->email->setSubject('Reset Password - PressStarter');
                $this->email->setMessage($message);

                if ($this->email->send()) {
                    $this->session->setFlashdata('success', 'Link reset password telah dikirim ke email Anda.');
                } else {
                    $this->session->setFlashdata('error', 'Gagal mengirim email. Silakan coba lagi.');
                }
            } else {
                $this->session->setFlashdata('error', 'Email tidak ditemukan.');
            }

            return redirect()->to('/auth/forgot-password');
        }

        return view('auth/forgot_password', ['title' => 'Forgot Password']);
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/auth/login');
        }

        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->session->setFlashdata('error', 'Token reset password tidak valid atau sudah expired.');
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return view('auth/reset_password', [
                    'validation' => $this->validator, 
                    'token' => $token,
                    'title' => 'Reset Password'
                ]);
            }

            $newPassword = $this->request->getPost('password');
            
            $this->userModel->update($user['id'], ['password' => $newPassword]);
            $this->userModel->clearResetToken($user['id']);

            $this->session->setFlashdata('success', 'Password berhasil direset. Silakan login dengan password baru.');
            return redirect()->to('/auth/login');
        }

        return view('auth/reset_password', [
            'token' => $token,
            'title' => 'Reset Password'
        ]);
    }

    public function logout()
    {
        // Clear remember token if exists
        if (isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->where('remember_token', $_COOKIE['remember_token'])->first();
            if ($user) {
                $this->userModel->update($user['id'], ['remember_token' => null]);
            }
            setcookie('remember_token', '', time() - 3600, '/');
        }

        $this->session->destroy();
        $this->session->setFlashdata('success', 'Anda telah logout.');
        return redirect()->to('/auth/login');
    }

    public function checkRememberToken()
    {
        if (!$this->session->get('user_id') && isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->where('remember_token', $_COOKIE['remember_token'])->first();
            
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
                $this->session->set($sessionData);
                return redirect()->to('/admin/dashboard');
            }
        }
    }
}
