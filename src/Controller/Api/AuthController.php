<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\I18n\Time;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\BadRequestException;

class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Sessions');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response = $this->response->withType('application/json');
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
            $user = $this->Users->patchEntity($user, $this->request->getData());
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
        }
    }

    public function logout()
    {
        if ($this->request->is('post')) {
            $this->Sessions->deleteAll(['user_id' => $this->Auth->user('id')]);
            $this->Auth->logout();
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
