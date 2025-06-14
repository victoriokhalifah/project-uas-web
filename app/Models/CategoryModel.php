<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug', 'description', 'is_active'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|min_length[3]|max_length[255]|is_unique[categories.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama kategori harus diisi',
            'min_length' => 'Nama kategori minimal 3 karakter'
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'is_unique' => 'Slug sudah digunakan'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name']) && empty($data['data']['slug'])) {
            $slug = url_title($data['data']['name'], '-', true);
            
            // Check if slug exists
            $count = $this->where('slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
            
            $data['data']['slug'] = $slug;
        }
        return $data;
    }

    public function getActiveCategories()
    {
        return $this->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
    }

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getCategoryStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('is_active', 1)->countAllResults(),
            'inactive' => $this->where('is_active', 0)->countAllResults(),
        ];
    }

    public function getCategoriesWithNewsCount()
    {
        return $this->select('categories.*, COUNT(news.id) as news_count')
                    ->join('news', 'news.category_id = categories.id', 'left')
                    ->groupBy('categories.id')
                    ->orderBy('categories.name', 'ASC')
                    ->findAll();
    }
}
