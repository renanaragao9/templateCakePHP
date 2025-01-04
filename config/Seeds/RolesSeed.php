<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

class RolesSeed extends AbstractSeed
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrador',
                'description' => 'Acesso total ao sistema',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('roles');
        $table->insert($roles)->save();
    }
}
