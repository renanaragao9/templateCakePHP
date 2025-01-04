<?php

use Cake\Auth\DefaultPasswordHasher;
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@aslafit.com',
                'password' => (new DefaultPasswordHasher)->hash('123456'),
                'last_login' => null,
                'login_count' => 0,
                'active' => true,
                'role_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
