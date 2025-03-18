<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Event\EventManager;

class ResetPasswordService
{
    protected $Users;

    public function __construct()
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    public function execute(string $email)
    {
        $user = $this->Users->findByEmail($email)->first();

        if (!$user) {
            return ['success' => false, 'message' => __('E-mail não encontrado.')];
        }

        $token = Security::hash(Security::randomBytes(25));
        $user->reset_token = $token;
        $user->token_created_at = Time::now();

        if ($this->Users->save($user)) {
            $event = new Event('Model.Users.afterPasswordReset', $this, [
                'user' => $user,
                'token' => $token,
            ]);
            EventManager::instance()->dispatch($event);

            return ['success' => true, 'message' => __('Um link de redefinição de senha foi enviado para seu e-mail.')];
        } else {
            return ['success' => false, 'message' => __('Erro ao gerar token de redefinição.')];
        }
    }
}
