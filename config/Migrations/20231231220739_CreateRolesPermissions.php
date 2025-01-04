<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRolesPermissions extends AbstractMigration
{
    public function change(): void
    {
        // Tabela de Roles
        $roles = $this->table('roles');
        $roles
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();

        // Tabela de Permissions
        $permissions = $this->table('permissions');
        $permissions
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('group', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();

        // Tabela de Roles_Permissions
        $rolesPermissions = $this->table('roles_permissions');
        $rolesPermissions
            ->addColumn(
                'role_id',
                'integer',
                ['null' => false]
            )
            ->addColumn(
                'permission_id',
                'integer',
                ['null' => false]
            )
            ->addColumn(
                'created',
                'datetime',
                ['default' => 'CURRENT_TIMESTAMP']
            )
            ->addColumn(
                'modified',
                'datetime',
                ['default' => 'CURRENT_TIMESTAMP']
            )
            ->addIndex(
                ['role_id', 'permission_id'],
                ['unique' => true]
            )
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION']
            )
            ->addForeignKey(
                'permission_id',
                'permissions',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION']
            )
            ->create();
    }
}
