<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@beritator.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name'  => 'Administrator',
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'editor',
                'email'      => 'editor@beritator.com',
                'password'   => password_hash('editor123', PASSWORD_DEFAULT),
                'full_name'  => 'Editor Utama',
                'role'       => 'editor',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'wartawan',
                'email'      => 'wartawan@beritator.com',
                'password'   => password_hash('wartawan123', PASSWORD_DEFAULT),
                'full_name'  => 'Wartawan Senior',
                'role'       => 'wartawan',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
