<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\Event\Event;

class ChangePasswordService
{
    protected $Users;

    public function __construct()
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    public function execute(string $token, array $data)
    {
        $user = $this->Users->findByResetToken($token)->first();

        if (!$user || !$user->token_created_at->wasWithinLast('1 day')) {
            $this->Users->getEventManager()->dispatch(new Event('Flash.error', null, [
                'message' => __('Token inválido ou expirado.'),
            ]));
            return ['success' => false, 'message' => __('Link inválido ou expirado.')];
        }

        $user = $this->Users->patchEntity($user, $data, ['validate' => 'password']);
        $user->password = (new DefaultPasswordHasher())->hash($user->password);
        $user->reset_token = null;
        $user->token_created_at = null;

        if ($this->Users->save($user)) {
            return ['success' => true, 'message' => __('Senha alterada com sucesso.')];
        } else {
            return ['success' => false, 'message' => __('Não foi possível alterar sua senha.')];
        }
    }
}
