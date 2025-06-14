<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'email', 'password', 'full_name', 'role', 
        'avatar', 'is_active', 'remember_token', 'reset_token', 'reset_expires'
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
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required|min_length[3]|max_length[255]',
        'role'     => 'required|in_list[admin,editor,wartawan]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 3 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function findByResetToken($token)
    {
        return $this->where('reset_token', $token)
                    ->where('reset_expires >', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function updateResetToken($userId, $token, $expires)
    {
        return $this->update($userId, [
            'reset_token' => $token,
            'reset_expires' => $expires
        ]);
    }

    public function clearResetToken($userId)
    {
        return $this->update($userId, [
            'reset_token' => null,
            'reset_expires' => null
        ]);
    }

    public function getUserStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('is_active', 1)->countAllResults(),
            'admin' => $this->where('role', 'admin')->countAllResults(),
            'editor' => $this->where('role', 'editor')->countAllResults(),
            'wartawan' => $this->where('role', 'wartawan')->countAllResults(),
        ];
    }
}
