<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 
        'category_id', 'author_id', 'status', 'published_at', 
        'approved_by', 'approved_at', 'views', 'meta_title', 'meta_description'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title'       => 'required|min_length[10]|max_length[500]',
        'content'     => 'required|min_length[50]',
        'category_id' => 'required|integer',
        'author_id'   => 'required|integer',
        'status'      => 'required|in_list[draft,pending,published,rejected]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul berita harus diisi',
            'min_length' => 'Judul berita minimal 10 karakter'
        ],
        'content' => [
            'required' => 'Konten berita harus diisi',
            'min_length' => 'Konten berita minimal 50 karakter'
        ],
        'category_id' => [
            'required' => 'Kategori harus dipilih'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug', 'generateExcerpt'];
    protected $beforeUpdate   = ['generateSlug', 'generateExcerpt'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $slug = url_title($data['data']['title'], '-', true);
            
            // Check if slug exists
            $count = $this->where('slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
            
            $data['data']['slug'] = $slug;
        }
        return $data;
    }

    protected function generateExcerpt(array $data)
    {
        if (isset($data['data']['content']) && empty($data['data']['excerpt'])) {
            $content = strip_tags($data['data']['content']);
            $data['data']['excerpt'] = substr($content, 0, 200) . '...';
        }
        return $data;
    }

    public function getNewsWithDetails($limit = null, $offset = null, $status = null)
    {
        $builder = $this->select('news.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name')
                        ->join('categories', 'categories.id = news.category_id')
                        ->join('users', 'users.id = news.author_id');
        
        if ($status) {
            $builder->where('news.status', $status);
        }
        
        $builder->orderBy('news.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getPublishedNews($limit = null, $offset = null, $categoryId = null)
    {
        $builder = $this->select('news.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name')
                        ->join('categories', 'categories.id = news.category_id')
                        ->join('users', 'users.id = news.author_id')
                        ->where('news.status', 'published');
        
        if ($categoryId) {
            $builder->where('news.category_id', $categoryId);
        }
        
        $builder->orderBy('news.published_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getPendingNews()
    {
        return $this->select('news.*, categories.name as category_name, users.full_name as author_name')
                    ->join('categories', 'categories.id = news.category_id')
                    ->join('users', 'users.id = news.author_id')
                    ->where('news.status', 'pending')
                    ->orderBy('news.created_at', 'DESC')
                    ->findAll();
    }

    public function getNewsByAuthor($authorId, $limit = null, $offset = null)
    {
        $builder = $this->select('news.*, categories.name as category_name')
                        ->join('categories', 'categories.id = news.category_id')
                        ->where('news.author_id', $authorId)
                        ->orderBy('news.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    public function findBySlug($slug)
    {
        return $this->select('news.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name')
                    ->join('categories', 'categories.id = news.category_id')
                    ->join('users', 'users.id = news.author_id')
                    ->where('news.slug', $slug)
                    ->first();
    }

    public function searchNews($keyword, $limit = null, $offset = null)
    {
        $builder = $this->select('news.*, categories.name as category_name, users.full_name as author_name')
                        ->join('categories', 'categories.id = news.category_id')
                        ->join('users', 'users.id = news.author_id')
                        ->where('news.status', 'published')
                        ->groupStart()
                            ->like('news.title', $keyword)
                            ->orLike('news.content', $keyword)
                            ->orLike('news.excerpt', $keyword)
                        ->groupEnd()
                        ->orderBy('news.published_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    public function incrementViews($id)
    {
        return $this->set('views', 'views + 1', false)->where('id', $id)->update();
    }

    public function approveNews($id, $approvedBy)
    {
        return $this->update($id, [
            'status' => 'published',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s'),
            'published_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function rejectNews($id, $approvedBy)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getNewsStats()
    {
        return [
            'total' => $this->countAll(),
            'published' => $this->where('status', 'published')->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'draft' => $this->where('status', 'draft')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults(),
            'total_views' => $this->selectSum('views')->get()->getRow()->views ?? 0,
        ];
    }

    public function getPopularNews($limit = 5)
    {
        return $this->select('news.*, categories.name as category_name')
                    ->join('categories', 'categories.id = news.category_id')
                    ->where('news.status', 'published')
                    ->orderBy('news.views', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getRelatedNews($categoryId, $excludeId, $limit = 4)
    {
        return $this->select('id, title, slug, featured_image, published_at, views')
                    ->where('category_id', $categoryId)
                    ->where('id !=', $excludeId)
                    ->where('status', 'published')
                    ->orderBy('published_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
