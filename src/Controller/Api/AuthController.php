<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\BadRequestException;

class AuthController extends AppController
{
    private const INACTIVITY_LIMIT = 3600; // 60 minutos

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Sessions');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response = $this->response->withType('application/json');
    }

    private function checkInactivity()
    {
        $session = $this->Sessions->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->order(['last_activity' => 'DESC'])
            ->first();

        if ($session) {
            $lastActivity = $session->last_activity->getTimestamp();
            $currentTime = Time::now()->getTimestamp();

            if (($currentTime - $lastActivity) > self::INACTIVITY_LIMIT) {
                $this->logout();
                throw new UnauthorizedException(__('Sessão expirada devido à inatividade.'));
            } else {
                $session->last_activity = Time::now();
                $this->Sessions->save($session);
            }
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $session = $this->request->getSession();
            $attempts = $session->read('Auth.attempts') ?? 0;

            if ($attempts >= 5) {
                throw new UnauthorizedException(__('Muitas tentativas de login. Tente novamente mais tarde.'));
            }

            $user = $this->Auth->identify();
            if ($user) {
                if ($user['active']) {
                    $userEntity = $this->Users->get($user['id'], [
                        'contain' => ['Roles'],
                    ]);

                    $userEntity->last_login = date('Y-m-d H:i:s');
                    $userEntity->login_count += 1;
                    $this->Users->save($userEntity);
                    $this->Auth->setUser($userEntity->toArray());

                    // Armazena token de sessão
                    $session = $this->Sessions->newEmptyEntity();
                    $session->user_id = $userEntity->id;
                    $session->token = bin2hex(random_bytes(32));
                    $session->last_activity = Time::now();
                    $this->Sessions->save($session);

                    $this->request->getSession()->delete('Auth.attempts');
                    $this->set([
                        'status' => 'success',
                        'data' => [
                            'token' => $session->token,
                            'user' => $userEntity
                        ],
                        '_serialize' => ['status', 'data']
                    ]);
                } else {
                    throw new UnauthorizedException(__('Sua conta está inativa.'));
                }
            } else {
                $session->write('Auth.attempts', $attempts + 1);
                throw new UnauthorizedException(__('Email ou senha inválidos, tente novamente.'));
            }
        } else {
            throw new BadRequestException(__('Método de requisição inválido.'));
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['password'] = (new \Cake\Auth\DefaultPasswordHasher())->hash($data['password']);
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->set([
                    'status' => 'success',
                    'message' => __('Registro bem-sucedido.'),
                    '_serialize' => ['status', 'message']
                ]);
            } else {
                throw new BadRequestException(__('Não foi possível registrar. Por favor, tente novamente.'));
            }
        } else {
            throw new BadRequestException(__('Método de requisição inválido.'));
        }
    }

    public function logout()
    {
        if ($this->request->is('post')) {
            $this->Sessions->deleteAll(['user_id' => $this->Auth->user('id')]);
            $this->Auth->logout();

            // Destruir CSRF token e cookie
            $this->request->getSession()->delete('csrfToken');
            $cookie = new \Cake\Http\Cookie\Cookie('csrfToken', '', new \DateTime('-1 hour'));
            $this->response = $this->response->withExpiredCookie($cookie);

            $this->set([
                'status' => 'success',
                'message' => __('Logout bem-sucedido.'),
                '_serialize' => ['status', 'message']
            ]);
        } else {
            throw new BadRequestException(__('Método de requisição inválido.'));
        }
    }
}
