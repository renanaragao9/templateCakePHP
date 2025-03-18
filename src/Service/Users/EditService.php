<?php

declare(strict_types=1);

namespace App\Service\Users;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;

class EditService
{
    private Table $users;

    public function __construct(Table $users)
    {
        $this->users = $users;
    }

    public function run(int $id, array $data): array
    {
        $user = $this->users->get($id);

        if (!empty($data['password'])) {
            $data['password'] = (new DefaultPasswordHasher())->hash($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->users->patchEntity($user, $data);

        if ($this->users->save($user)) {
            return ['success' => true, 'message' => __('O usuário foi editado com sucesso.')];
        }

        return ['success' => false, 'message' => __('O usuário não pode ser editado. Por favor, tente novamente.')];
    }

    public function getEditData(int $id): array
    {
        $user = $this->users->get($id, ['contain' => []]);
        $roles = $this->users->Roles->find('list', ['limit' => 200])->all();

        return compact('user', 'roles');
    }
}
