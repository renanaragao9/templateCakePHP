<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

class PermissionsSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            // Comando para roda o seed: bin/cake migrations seed --seed PermissionsSeed

            // Dashboard Seeder
            ['name' => 'Dashboard/index', 'description' => 'Listar', 'group' => 'Dashboard'],

            #Users Seeder
            ['name' => 'users/index', 'description' => 'Visualizar', 'group' => 'Users'],
            ['name' => 'users/add', 'description' => 'Criar', 'group' => 'Users'],
            ['name' => 'users/edit', 'description' => 'Editar', 'group' => 'Users'],
            ['name' => 'users/delete', 'description' => 'Deletar', 'group' => 'Users'],

            // Roles Seeder
            ['name' => 'roles/index', 'description' => 'Listar', 'group' => 'Perfil'],
            ['name' => 'roles/add', 'description' => 'Criar', 'group' => 'Perfil'],
            ['name' => 'roles/edit', 'description' => 'Editar', 'group' => 'Perfil'],
            ['name' => 'roles/delete', 'description' => 'Deletar', 'group' => 'Perfil'],
        ];

        $table = $this->table('permissions');
        $table->insert($data)->save();
    }
}
