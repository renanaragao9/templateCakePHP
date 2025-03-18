<?php

declare(strict_types=1);

namespace App\Service\Roles;

use Cake\ORM\Table;

class DeleteService
{
    private Table $roles;

    public function __construct(Table $roles)
    {
        $this->roles = $roles;
    }

    public function run(int $id): array
    {
        if ($id === 1) {
            return ['success' => false, 'message' => __('O perfil de administrador não pode ser apagado.')];
        }

        $role = $this->roles->get($id);

        if ($this->roles->delete($role)) {
            $this->roles->RolesPermissions->deleteAll(['role_id' => $role->id]);
            return ['success' => true, 'message' => __('O perfil foi deletado com sucesso.')];
        }

        return ['success' => false, 'message' => __('O perfil não pode ser deletado. Por favor, tente novamente.')];
    }
}
