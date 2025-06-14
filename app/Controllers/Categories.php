<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Categories extends Controller
{
    protected $categoryModel;
    protected $session;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->session = \Config\Services::session();
        
        // Check if user is logged in and has admin/editor role
        if (!$this->session->get('logged_in')) {
            header('Location: ' . base_url('auth/login'));
            exit();
        }

        $userRole = $this->session->get('role');
        if (!in_array($userRole, ['admin', 'editor'])) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            header('Location: ' . base_url('admin/dashboard'));
            exit();
        }
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();

        $data = [
            'title' => 'Kelola Kategori',
            'categories' => $categories
        ];

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'slug' => 'permit_empty|min_length[3]|max_length[255]|is_unique[categories.slug]',
                'description' => 'permit_empty'
            ];

            if (!$this->validate($rules)) {
                return view('admin/categories/create', ['validation' => $this->validator]);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'slug' => $this->request->getPost('slug') ?: url_title($this->request->getPost('name'), '-', true),
                'description' => $this->request->getPost('description'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->categoryModel->insert($data)) {
                $this->session->setFlashdata('success', 'Kategori berhasil dibuat.');
                return redirect()->to('/admin/categories');
            } else {
                $this->session->setFlashdata('error', 'Gagal membuat kategori.');
            }
        }

        return view('admin/categories/create');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'slug' => "permit_empty|min_length[3]|max_length[255]|is_unique[categories.slug,id,{$id}]",
                'description' => 'permit_empty'
            ];

            if (!$this->validate($rules)) {
                return view('admin/categories/edit', [
                    'validation' => $this->validator,
                    'category' => $category
                ]);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'slug' => $this->request->getPost('slug') ?: url_title($this->request->getPost('name'), '-', true),
                'description' => $this->request->getPost('description'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->categoryModel->update($id, $data)) {
                $this->session->setFlashdata('success', 'Kategori berhasil diupdate.');
                return redirect()->to('/admin/categories');
            } else {
                $this->session->setFlashdata('error', 'Gagal mengupdate kategori.');
            }
        }

        return view('admin/categories/edit', ['category' => $category]);
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            $this->session->setFlashdata('error', 'Kategori tidak ditemukan.');
            return redirect()->to('/admin/categories');
        }

        // Check if category is used by news
        $newsModel = new \App\Models\NewsModel();
        $newsCount = $newsModel->where('category_id', $id)->countAllResults();
        
        if ($newsCount > 0) {
            $this->session->setFlashdata('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh berita.');
            return redirect()->to('/admin/categories');
        }

        if ($this->categoryModel->delete($id)) {
            $this->session->setFlashdata('success', 'Kategori berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Gagal menghapus kategori.');
        }

        return redirect()->to('/admin/categories');
    }
}
