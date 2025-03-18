<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Cake\Http\Session;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;

class LoginService
{
    protected $Users;
    protected $Sessions;
    protected $session;

    public function __construct(Session $session)
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Sessions = TableRegistry::getTableLocator()->get('Sessions');
        $this->session = $session;
    }

    public function run(array $data)
    {
        $attempts = $this->session->read('Auth.attempts') ?? 0;

        if ($attempts >= 5) {
            return ['success' => false, 'message' => __('Muitas tentativas de login. Tente novamente mais tarde.')];
        }

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return ['success' => false, 'message' => __('Email e senha são obrigatórios.')];
        }

        $user = $this->Users->find()->where(['email' => $email])->first();

        if (!$user) {
            return ['success' => false, 'message' => __('Conta não registrada. Por favor, cadastre-se.')];
        }

        if (!(new DefaultPasswordHasher())->check($password, $user->password)) {
            $this->session->write('Auth.attempts', $attempts + 1);
            return ['success' => false, 'message' => __('Senha incorreta. Por favor, tente novamente.')];
        }

        if (!$user->active) {
            return ['success' => false, 'message' => __('Sua conta está inativa.')];
        }

        // Atualiza login e salva sessão do usuário
        $user->last_login = Time::now();
        $user->login_count += 1;
        $this->Users->save($user);

        $session = $this->Sessions->newEmptyEntity();
        $session->user_id = $user->id;
        $session->token = bin2hex(random_bytes(32));
        $session->last_activity = Time::now();
        $this->Sessions->save($session);

        $this->session->delete('Auth.attempts');

        return ['success' => true, 'user' => $user, 'token' => $session->token];
    }
}
