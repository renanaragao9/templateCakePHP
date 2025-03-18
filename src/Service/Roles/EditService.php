<?php

declare(strict_types=1);

namespace App\Service\Roles;

use Cake\ORM\Table;

class EditService
{
    private Table $roles;

    public function __construct(Table $roles)
    {
        $this->roles = $roles;
    }

    public function run(int $id, array $data): array
    {
        $role = $this->roles->get($id, ['contain' => ['Permissions']]);
        $role = $this->roles->patchEntity($role, $data);

        if ($this->roles->save($role)) {
            // Remove as permissões existentes
            $this->roles->RolesPermissions->deleteAll(['role_id' => $role->id]);

            // Adiciona as novas permissões
            if (!empty($data['permissions'])) {
                foreach ($data['permissions'] as $permissionId) {
                    $rolePermission = $this->roles->RolesPermissions->newEmptyEntity();
                    $rolePermission->role_id = $role->id;
                    $rolePermission->permission_id = (int)$permissionId;
                    $this->roles->RolesPermissions->save($rolePermission);
                }
            }

            return ['success' => true, 'message' => __('O perfil foi editado com sucesso.')];
        }

        return ['success' => false, 'message' => __('O perfil não pode ser salvo. Por favor, tente novamente.')];
    }

    public function getEditData(int $id): array
    {
        $role = $this->roles->get($id, ['contain' => ['Permissions']]);
        $permissions = $this->roles->Permissions->find('list', ['limit' => 200])->all();

        return compact('role', 'permissions');
    }
}
