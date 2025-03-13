<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

class RolesPermissionsSeed extends AbstractSeed
{
    public function run(): void
    {
        // ID da role "Administrador"
        $adminRoleId = 1;

        // IDs de todas as permissões
        $permissionsTable = $this->table('permissions');
        $permissions = $this->fetchAll('SELECT id FROM permissions');
        $rolesPermissions = [];

        foreach ($permissions as $permission) {
            $rolesPermissions[] = [
                'role_id' => $adminRoleId,
                'permission_id' => $permission['id'],
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];
        }

        $rolesPermissionsTable = $this->table('roles_permissions');
        $rolesPermissionsTable->insert($rolesPermissions)->save();
    }
}
