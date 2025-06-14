<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        
        // Check if user is logged in and has admin role
        if (!$this->session->get('logged_in')) {
            header('Location: ' . base_url('auth/login'));
            exit();
        }

        $userRole = $this->session->get('role');
        if ($userRole !== 'admin') {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            header('Location: ' . base_url('admin/dashboard'));
            exit();
        }
    }

    public function index()
    {
        $users = $this->userModel->findAll();

        $data = [
            'title' => 'Kelola User',
            'users' => $users
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,wartawan]'
            ];

            if (!$this->validate($rules)) {
                return view('admin/users/create', ['validation' => $this->validator]);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'full_name' => $this->request->getPost('full_name'),
                'role' => $this->request->getPost('role'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->userModel->insert($data)) {
                $this->session->setFlashdata('success', 'User berhasil dibuat.');
                return redirect()->to('/admin/users');
            } else {
                $this->session->setFlashdata('error', 'Gagal membuat user.');
            }
        }

        return view('admin/users/create');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,wartawan]'
            ];

            // Add password validation if password is provided
            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[6]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules)) {
                return view('admin/users/edit', [
                    'validation' => $this->validator,
                    'user' => $user
                ]);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name'),
                'role' => $this->request->getPost('role'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            // Update password if provided
            if ($this->request->getPost('password')) {
                $data['password'] = $this->request->getPost('password');
            }

            if ($this->userModel->update($id, $data)) {
                $this->session->setFlashdata('success', 'User berhasil diupdate.');
                return redirect()->to('/admin/users');
            } else {
                $this->session->setFlashdata('error', 'Gagal mengupdate user.');
            }
        }

        return view('admin/users/edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $this->session->setFlashdata('error', 'User tidak ditemukan.');
            return redirect()->to('/admin/users');
        }

        // Prevent deleting current user
        if ($id == $this->session->get('user_id')) {
            $this->session->setFlashdata('error', 'Anda tidak dapat menghapus akun sendiri.');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            $this->session->setFlashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Gagal menghapus user.');
        }

        return redirect()->to('/admin/users');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            $this->session->setFlashdata('error', 'User tidak ditemukan.');
            return redirect()->to('/admin/users');
        }

        // Prevent deactivating current user
        if ($id == $this->session->get('user_id')) {
            $this->session->setFlashdata('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
            return redirect()->to('/admin/users');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        
        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            $this->session->setFlashdata('success', "User berhasil {$statusText}.");
        } else {
            $this->session->setFlashdata('error', 'Gagal mengubah status user.');
        }

        return redirect()->to('/admin/users');
    }
}

