<?php

declare(strict_types=1);

namespace App\Service\Roles;

use Cake\ORM\Table;

class AddService
{
    private Table $roles;

    public function __construct(Table $roles)
    {
        $this->roles = $roles;
    }

    public function run(array $data): array
    {
        $role = $this->roles->newEmptyEntity();
        $role = $this->roles->patchEntity($role, $data);

        if ($this->roles->save($role)) {
            if (!empty($data['permissions'])) {
                foreach ($data['permissions'] as $permissionId) {
                    $rolePermission = $this->roles->RolesPermissions->newEmptyEntity();
                    $rolePermission->role_id = $role->id;
                    $rolePermission->permission_id = (int)$permissionId;
                    $this->roles->RolesPermissions->save($rolePermission);
                }
            }

            return ['success' => true, 'message' => __('O perfil foi salvo com sucesso.')];
        }

        return ['success' => false, 'message' => __('O perfil não pode ser salvo. Por favor, tente novamente.')];
    }

    public function getNewEntity()
    {
        return $this->roles->newEmptyEntity();
    }
}
