<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;

class AccessChecker
{
    public static function hasPermission($userId, $permissionName)
    {
        // Tabela de usuários
        $usersTable = TableRegistry::getTableLocator()->get('Users');

        // Recupera o usuário com sua role
        $user = $usersTable->get($userId, ['contain' => ['Roles']]);

        if (!$user || !$user->role_id) {
            return false; // Retorna falso se o usuário ou o role_id não forem encontrados
        }

        // Tabela de roles_permissions
        $rolesPermissionsTable = TableRegistry::getTableLocator()->get('RolesPermissions');

        // Tabela de permissões
        $permissionsTable = TableRegistry::getTableLocator()->get('Permissions');

        // Verifica se a permissão existe
        $permission = $permissionsTable->find()
            ->where(['name' => $permissionName])
            ->first();

        if (!$permission) {
            return false; // Retorna falso se a permissão não existir
        }

        // Verifica se o role do usuário tem a permissão associada
        return $rolesPermissionsTable->exists([
            'role_id' => $user->role_id,
            'permission_id' => $permission->id,
        ]);
    }
}
