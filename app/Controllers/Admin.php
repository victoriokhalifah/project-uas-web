<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\NewsModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $userModel;
    protected $categoryModel;
    protected $newsModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->newsModel = new NewsModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    public function dashboard()
    {
        $newsStats = $this->newsModel->getNewsStats();
        $userStats = $this->userModel->getUserStats();
        $categoryStats = $this->categoryModel->getCategoryStats();

        $data = [
            'title' => 'Dashboard',
            // News statistics
            'total_news' => $newsStats['total'],
            'published_news' => $newsStats['published'],
            'pending_news' => $newsStats['pending'],
            'draft_news' => $newsStats['draft'],
            'rejected_news' => $newsStats['rejected'],
            'total_views' => $newsStats['total_views'],
            
            // User statistics
            'total_users' => $userStats['total'],
            'active_users' => $userStats['active'],
            'admin_users' => $userStats['admin'],
            'editor_users' => $userStats['editor'],
            'wartawan_users' => $userStats['wartawan'],
            
            // Category statistics
            'total_categories' => $categoryStats['total'],
            'active_categories' => $categoryStats['active'],
            'inactive_categories' => $categoryStats['inactive'],
            
            // Recent data
            'recent_news' => $this->newsModel->getNewsWithDetails(10),
            'popular_news' => $this->newsModel->getPopularNews(5)
        ];

        return view('admin/dashboard', $data);
    }

    public function profile()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$userId}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
                'full_name' => 'required|min_length[3]|max_length[255]'
            ];

            // Add password validation if password is provided
            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[6]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules)) {
                return view('admin/profile', [
                    'validation' => $this->validator, 
                    'user' => $user,
                    'title' => 'Edit Profile'
                ]);
            }

            $updateData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name')
            ];

            // Update password if provided
            if ($this->request->getPost('password')) {
                $updateData['password'] = $this->request->getPost('password');
            }

            // Handle avatar upload
            $avatar = $this->request->getFile('avatar');
            if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
                // Validate file
                if (!$avatar->isValid()) {
                    $this->session->setFlashdata('error', 'File avatar tidak valid.');
                    return redirect()->to('/admin/profile');
                }

                // Check file type
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($avatar->getMimeType(), $allowedTypes)) {
                    $this->session->setFlashdata('error', 'Format file harus JPG, PNG, atau GIF.');
                    return redirect()->to('/admin/profile');
                }

                // Check file size (max 2MB)
                if ($avatar->getSize() > 2048000) {
                    $this->session->setFlashdata('error', 'Ukuran file maksimal 2MB.');
                    return redirect()->to('/admin/profile');
                }

                $avatarName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'public/uploads/avatars', $avatarName);
                $updateData['avatar'] = $avatarName;

                // Delete old avatar
                if ($user['avatar'] && file_exists(ROOTPATH . 'public/uploads/avatars/' . $user['avatar'])) {
                    unlink(ROOTPATH . 'public/uploads/avatars/' . $user['avatar']);
                }
            }

            if ($this->userModel->update($userId, $updateData)) {
                // Update session data
                $this->session->set([
                    'username' => $updateData['username'],
                    'email' => $updateData['email'],
                    'full_name' => $updateData['full_name'],
                    'avatar' => $updateData['avatar'] ?? $user['avatar']
                ]);

                $this->session->setFlashdata('success', 'Profile berhasil diupdate.');
            } else {
                $this->session->setFlashdata('error', 'Gagal mengupdate profile.');
            }

            return redirect()->to('/admin/profile');
        }

        return view('admin/profile', [
            'user' => $user,
            'title' => 'Edit Profile'
        ]);
    }
}

