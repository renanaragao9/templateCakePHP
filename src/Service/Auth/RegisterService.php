<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Cake\ORM\TableRegistry;

class RegisterService
{
    protected $Users;

    public function __construct()
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    public function execute(array $data)
    {
        $user = $this->Users->newEmptyEntity();
        $user = $this->Users->patchEntity($user, $data);

        if ($this->Users->save($user)) {
            return ['success' => true, 'message' => __('Registro bem-sucedido.')];
        } else {
            return ['success' => false, 'message' => __('Não foi possível registrar. Por favor, tente novamente.')];
        }
    }
}
