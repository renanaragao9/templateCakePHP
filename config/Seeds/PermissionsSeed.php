<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

class PermissionsSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            // Comando para roda o seed: bin/cake migrations seed --seed PermissionsSeed

            // Users Seeder
            ['name' => 'Users/index', 'description' => 'Listar', 'group' => 'Usuários'],
            ['name' => 'Users/add', 'description' => 'Criar', 'group' => 'Usuários'],
            ['name' => 'Users/edit', 'description' => 'Editar', 'group' => 'Usuários'],
            ['name' => 'Users/delete', 'description' => 'Deletar', 'group' => 'Usuários'],

            // Dashboard Seeder
            ['name' => 'Dashboard/index', 'description' => 'Listar', 'group' => 'Dashboard'],

            // Roles Seeder
            ['name' => 'Roles/index', 'description' => 'Listar', 'group' => 'Perfil'],
            ['name' => 'Roles/add', 'description' => 'Criar', 'group' => 'Perfil'],
            ['name' => 'Roles/edit', 'description' => 'Editar', 'group' => 'Perfil'],
            ['name' => 'Roles/delete', 'description' => 'Deletar', 'group' => 'Perfil'],
        ];
        $table = $this->table('permissions');
        $table->insert($data)->save();
    }
}
