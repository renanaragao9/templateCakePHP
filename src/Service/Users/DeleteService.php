<?php

declare(strict_types=1);

namespace App\Service\Users;

use Cake\ORM\Table;

class DeleteService
{
    private Table $users;

    public function __construct(Table $users)
    {
        $this->users = $users;
    }

    public function run(int $id): array
    {
        $user = $this->users->get($id);

        if ($this->users->delete($user)) {
            return ['success' => true, 'message' => __('O usuário foi deletado com sucesso.')];
        }

        return ['success' => false, 'message' => __('O usuário não pode ser deletado. Por favor, tente novamente.')];
    }
}
