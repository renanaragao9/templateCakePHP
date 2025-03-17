<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\I18n\Time;

class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Sessions');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'register']);

        if ($this->Auth->user() && $this->request->getParam('action') === 'login') {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        // Verifica inatividade do usuário
        if ($this->Auth->user()) {
            $session = $this->Sessions->find()
                ->where(['user_id' => $this->Auth->user('id')])
                ->first();

            if ($session && $session->last_activity->wasWithinLast('30 minutes')) {
                $session->last_activity = Time::now();
                $this->Sessions->save($session);
            } else {
                $this->Flash->error(__('Sessão expirada por inatividade.'));
                return $this->redirect($this->Auth->logout());
            }
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $session = $this->request->getSession();
            $attempts = $session->read('Auth.attempts') ?? 0;

            if ($attempts >= 5) {
                $this->Flash->error(__('Muitas tentativas de login. Tente novamente mais tarde.'));
                return;
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
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('Sua conta está inativa.'));
                }
            } else {
                $this->Flash->error(__('Email ou senha inválidos, tente novamente.'));
                $session->write('Auth.attempts', $attempts + 1);
            }
        }
        $this->viewBuilder()->setLayout('CakeLte.login');
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registro bem-sucedido.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Não foi possível registrar. Por favor, tente novamente.'));
        }
        $this->set(compact('user'));
    }

    public function logout()
    {
        // Remove token de sessão
        $this->Sessions->deleteAll(['user_id' => $this->Auth->user('id')]);
        return $this->redirect($this->Auth->logout());
    }
}
