<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users'); // Load the Users model
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);

        if ($this->Auth->user() && $this->request->getParam('action') === 'login') {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if ($user['active']) {
                    $userEntity = $this->Users->get($user['id'], [
                        'contain' => ['AcademyConfig'],
                    ]);
                    $userEntity->last_login = date('Y-m-d H:i:s');
                    $userEntity->login_count += 1;
                    $this->Users->save($userEntity);
                    $this->Auth->setUser($userEntity->toArray());
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('Sua conta está inativa.'));
                }
            } else {
                $this->Flash->error(__('Email ou senha inválidos, tente novamente.'));
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
        return $this->redirect($this->Auth->logout());
    }
}
