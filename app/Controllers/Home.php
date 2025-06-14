<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    protected $newsModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->categoryModel = new CategoryModel();
        helper(['text', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'PressStarter - Portal Berita Terpercaya',
            'latest_news' => $this->newsModel->getPublishedNews(6),
            'popular_news' => $this->newsModel->getPopularNews(5),
            'categories' => $this->categoryModel->getActiveCategories(),
            'search_query' => $this->request->getGet('q') ?? ''
        ];

        return view('frontend/home', $data);
    }

    public function news($slug)
    {
        $news = $this->newsModel->findBySlug($slug);
        
        if (!$news || $news['status'] !== 'published') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }

        // Increment views
        $this->newsModel->incrementViews($news['id']);

        $data = [
            'title' => $news['title'] . ' - PressStarter',
            'news' => $news,
            'related_news' => $this->newsModel->getRelatedNews($news['category_id'], $news['id'], 4),
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('frontend/news_detail', $data);
    }

    public function category($slug)
    {
        $category = $this->categoryModel->findBySlug($slug);
        
        if (!$category || $category['is_active'] != 1) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        // Pagination
        $pager = \Config\Services::pager();
        $page = (int) ($this->request->getVar('page') ?? 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $news = $this->newsModel->getPublishedNews($perPage, $offset, $category['id']);
        $totalNews = $this->newsModel->where('category_id', $category['id'])
                                    ->where('status', 'published')
                                    ->countAllResults();

        $data = [
            'title' => 'Kategori: ' . $category['name'] . ' - PressStarter',
            'category' => $category,
            'news' => $news,
            'pager' => $pager,
            'total_news' => $totalNews,
            'current_page' => $page,
            'per_page' => $perPage,
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('frontend/category', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        
        if (!$keyword) {
            return redirect()->to('/');
        }

        // Pagination
        $pager = \Config\Services::pager();
        $page = (int) ($this->request->getVar('page') ?? 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $news = $this->newsModel->searchNews($keyword, $perPage, $offset);
        $totalNews = $this->newsModel->searchNews($keyword);

        $data = [
            'title' => 'Pencarian: ' . $keyword . ' - PressStarter',
            'keyword' => $keyword,
            'news' => $news,
            'pager' => $pager,
            'total_news' => count($totalNews),
            'current_page' => $page,
            'per_page' => $perPage,
            'categories' => $this->categoryModel->getActiveCategories()
        ];

        return view('frontend/search', $data);
    }

    public function loadMore()
    {
        $page = (int) ($this->request->getPost('page') ?? 1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;

        $news = $this->newsModel->getPublishedNews($perPage, $offset);
        
        if (empty($news)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada berita lagi'
            ]);
        }

        $html = '';
        foreach ($news as $item) {
            $html .= view('frontend/partials/news_card', ['news' => $item]);
        }

        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
            'hasMore' => count($news) === $perPage
        ]);
    }

    public function newsletter()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/');
        }

        $email = $this->request->getPost('email');
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email tidak valid'
            ]);
        }

        // Here you would typically save to database or send to email service
        // For now, we'll just return success
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Terima kasih! Anda telah berlangganan newsletter kami.'
        ]);
    }
}
