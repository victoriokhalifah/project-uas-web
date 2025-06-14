<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class News extends Controller
{
    protected $newsModel;
    protected $categoryModel;
    protected $session;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->categoryModel = new CategoryModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url', 'text']);
    }

    public function index()
    {
        $userRole = $this->session->get('role');
        $userId = $this->session->get('user_id');

        if ($userRole === 'wartawan') {
            $news = $this->newsModel->getNewsByAuthor($userId);
        } else {
            $news = $this->newsModel->getNewsWithDetails();
        }

        $data = [
            'title' => 'Kelola Berita',
            'news' => $news
        ];

        return view('admin/news/index', $data);
    }

    public function create()
    {
        $categories = $this->categoryModel->getActiveCategories();

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[10]|max_length[500]',
                'content' => 'required|min_length[50]',
                'category_id' => 'required|integer'
            ];

            if (!$this->validate($rules)) {
                return view('admin/news/create', [
                    'validation' => $this->validator,
                    'categories' => $categories,
                    'title' => 'Tambah Berita'
                ]);
            }

            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'category_id' => $this->request->getPost('category_id'),
                'author_id' => $this->session->get('user_id'),
                'status' => 'draft'
            ];

            // Handle featured image upload
            $featuredImage = $this->request->getFile('featured_image');
            if ($featuredImage && $featuredImage->isValid() && !$featuredImage->hasMoved()) {
                // Validate file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($featuredImage->getMimeType(), $allowedTypes)) {
                    $this->session->setFlashdata('error', 'Format gambar harus JPG, PNG, atau GIF.');
                    return view('admin/news/create', [
                        'categories' => $categories,
                        'title' => 'Tambah Berita'
                    ]);
                }

                // Check file size (max 5MB)
                if ($featuredImage->getSize() > 5242880) {
                    $this->session->setFlashdata('error', 'Ukuran gambar maksimal 5MB.');
                    return view('admin/news/create', [
                        'categories' => $categories,
                        'title' => 'Tambah Berita'
                    ]);
                }

                $imageName = $featuredImage->getRandomName();
                $featuredImage->move(ROOTPATH . 'public/uploads/news', $imageName);
                $data['featured_image'] = $imageName;
            }

            if ($this->newsModel->insert($data)) {
                $this->session->setFlashdata('success', 'Berita berhasil dibuat.');
                return redirect()->to('/admin/news');
            } else {
                $this->session->setFlashdata('error', 'Gagal membuat berita.');
            }
        }

        return view('admin/news/create', [
            'categories' => $categories,
            'title' => 'Tambah Berita'
        ]);
    }

    public function edit($id)
    {
        $news = $this->newsModel->find($id);
        if (!$news) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }

        // Check permission
        $userRole = $this->session->get('role');
        $userId = $this->session->get('user_id');
        
        if ($userRole === 'wartawan' && $news['author_id'] != $userId) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses untuk mengedit berita ini.');
            return redirect()->to('/admin/news');
        }

        $categories = $this->categoryModel->getActiveCategories();

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[10]|max_length[500]',
                'content' => 'required|min_length[50]',
                'category_id' => 'required|integer'
            ];

            if (!$this->validate($rules)) {
                return view('admin/news/edit', [
                    'validation' => $this->validator,
                    'news' => $news,
                    'categories' => $categories,
                    'title' => 'Edit Berita'
                ]);
            }

            $updateData = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'category_id' => $this->request->getPost('category_id')
            ];

            // Handle featured image upload
            $featuredImage = $this->request->getFile('featured_image');
            if ($featuredImage && $featuredImage->isValid() && !$featuredImage->hasMoved()) {
                // Validate file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($featuredImage->getMimeType(), $allowedTypes)) {
                    $this->session->setFlashdata('error', 'Format gambar harus JPG, PNG, atau GIF.');
                    return view('admin/news/edit', [
                        'news' => $news,
                        'categories' => $categories,
                        'title' => 'Edit Berita'
                    ]);
                }

                // Check file size (max 5MB)
                if ($featuredImage->getSize() > 5242880) {
                    $this->session->setFlashdata('error', 'Ukuran gambar maksimal 5MB.');
                    return view('admin/news/edit', [
                        'news' => $news,
                        'categories' => $categories,
                        'title' => 'Edit Berita'
                    ]);
                }

                $imageName = $featuredImage->getRandomName();
                $featuredImage->move(ROOTPATH . 'public/uploads/news', $imageName);
                $updateData['featured_image'] = $imageName;

                // Delete old image
                if ($news['featured_image'] && file_exists(ROOTPATH . 'public/uploads/news/' . $news['featured_image'])) {
                    unlink(ROOTPATH . 'public/uploads/news/' . $news['featured_image']);
                }
            }

            if ($this->newsModel->update($id, $updateData)) {
                $this->session->setFlashdata('success', 'Berita berhasil diupdate.');
                return redirect()->to('/admin/news');
            } else {
                $this->session->setFlashdata('error', 'Gagal mengupdate berita.');
            }
        }

        return view('admin/news/edit', [
            'news' => $news, 
            'categories' => $categories,
            'title' => 'Edit Berita'
        ]);
    }

    public function delete($id)
    {
        $news = $this->newsModel->find($id);
        if (!$news) {
            $this->session->setFlashdata('error', 'Berita tidak ditemukan.');
            return redirect()->to('/admin/news');
        }

        // Check permission
        $userRole = $this->session->get('role');
        $userId = $this->session->get('user_id');
        
        if ($userRole === 'wartawan' && $news['author_id'] != $userId) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses untuk menghapus berita ini.');
            return redirect()->to('/admin/news');
        }

        // Delete featured image
        if ($news['featured_image'] && file_exists(ROOTPATH . 'public/uploads/news/' . $news['featured_image'])) {
            unlink(ROOTPATH . 'public/uploads/news/' . $news['featured_image']);
        }

        if ($this->newsModel->delete($id)) {
            $this->session->setFlashdata('success', 'Berita berhasil dihapus.');
        } else {
            $this->session->setFlashdata('error', 'Gagal menghapus berita.');
        }

        return redirect()->to('/admin/news');
    }

    public function submit($id)
    {
        $news = $this->newsModel->find($id);
        if (!$news) {
            $this->session->setFlashdata('error', 'Berita tidak ditemukan.');
            return redirect()->to('/admin/news');
        }

        // Check permission - only author can submit
        $userId = $this->session->get('user_id');
        if ($news['author_id'] != $userId) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses untuk submit berita ini.');
            return redirect()->to('/admin/news');
        }

        if ($this->newsModel->update($id, ['status' => 'pending'])) {
            $this->session->setFlashdata('success', 'Berita berhasil disubmit untuk review.');
        } else {
            $this->session->setFlashdata('error', 'Gagal submit berita.');
        }

        return redirect()->to('/admin/news');
    }

    public function pending()
    {
        // Only editor and admin can access
        $userRole = $this->session->get('role');
        if (!in_array($userRole, ['admin', 'editor'])) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            return redirect()->to('/admin/dashboard');
        }

        $pendingNews = $this->newsModel->getPendingNews();

        $data = [
            'title' => 'Berita Pending',
            'news' => $pendingNews
        ];

        return view('admin/news/pending', $data);
    }

    public function approve($id)
    {
        // Only editor and admin can approve
        $userRole = $this->session->get('role');
        if (!in_array($userRole, ['admin', 'editor'])) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses untuk approve berita.');
            return redirect()->to('/admin/news');
        }

        $news = $this->newsModel->find($id);
        if (!$news) {
            $this->session->setFlashdata('error', 'Berita tidak ditemukan.');
            return redirect()->to('/admin/news/pending');
        }

        $userId = $this->session->get('user_id');
        if ($this->newsModel->approveNews($id, $userId)) {
            $this->session->setFlashdata('success', 'Berita berhasil diapprove dan dipublish.');
        } else {
            $this->session->setFlashdata('error', 'Gagal approve berita.');
        }

        return redirect()->to('/admin/news/pending');
    }

    public function reject($id)
    {
        // Only editor and admin can reject
        $userRole = $this->session->get('role');
        if (!in_array($userRole, ['admin', 'editor'])) {
            $this->session->setFlashdata('error', 'Anda tidak memiliki akses untuk reject berita.');
            return redirect()->to('/admin/news');
        }

        $news = $this->newsModel->find($id);
        if (!$news) {
            $this->session->setFlashdata('error', 'Berita tidak ditemukan.');
            return redirect()->to('/admin/news/pending');
        }

        $userId = $this->session->get('user_id');
        if ($this->newsModel->rejectNews($id, $userId)) {
            $this->session->setFlashdata('success', 'Berita berhasil direject.');
        } else {
            $this->session->setFlashdata('error', 'Gagal reject berita.');
        }

        return redirect()->to('/admin/news/pending');
    }

    public function uploadImage()
    {
        // Handle image upload for Summernote editor
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (in_array($file->getMimeType(), $allowedTypes)) {
                    $fileName = $file->getRandomName();
                    $file->move(ROOTPATH . 'public/uploads/news', $fileName);
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'url' => base_url('uploads/news/' . $fileName)
                    ]);
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Upload gagal'
        ]);
    }
}
