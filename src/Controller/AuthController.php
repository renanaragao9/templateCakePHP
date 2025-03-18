<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Service\Auth\LoginService;
use App\Service\Auth\RegisterService;
use App\Service\Auth\ResetPasswordService;
use App\Service\Auth\ChangePasswordService;
use App\Service\Auth\LogoutService;
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

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'register', 'resetPassword', 'changePassword', 'testEmail']);

        if ($this->Auth->user() && $this->request->getParam('action') === 'login') {
            $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        if ($this->Auth->user()) {
            $session = $this->Sessions->find()
                ->where(['user_id' => $this->Auth->user('id')])
                ->first();

            if ($session && $session->last_activity->wasWithinLast('30 minutes')) {
                $session->last_activity = Time::now();
                $this->Sessions->save($session);
            } else {
                $this->Flash->error(__('Sessão expirada por inatividade.'));
                $this->redirect($this->Auth->logout());
            }
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $service = new LoginService($this->request->getSession());
            $result = $service->run($this->request->getData());

            if ($result['success']) {
                $this->Auth->setUser($result['user']->toArray());
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error($result['message']);
            }
        }

        $this->viewBuilder()->setLayout('CakeLte.login');
    }

    public function register()
    {
        if ($this->request->is('post')) {
            $service = new RegisterService();
            $result = $service->execute($this->request->getData());

            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'login']);
        }
    }

    public function resetPassword()
    {
        if ($this->request->is('post')) {
            $service = new ResetPasswordService($this->Users);
            $result = $service->execute($this->request->getData('email'));

            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'login']);
        }
    }

    public function changePassword($token = null)
    {
        $this->viewBuilder()->setLayout('CakeLte.change_password');
        $this->set('token', $token);;

        $user = $this->Users->findByResetToken($token)->first();
        if (!$user || !$token) {
            $this->Flash->error(__('O link fornecido é inválido.'));
            return $this->redirect(['action' => 'login']);
        }

        if ($this->request->is('post')) {
            $service = new ChangePasswordService($this->Users);
            $result = $service->execute($token, $this->request->getData());

            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'login']);
        }
    }

    public function logout()
    {
        $service = new LogoutService($this->Sessions, $this->request->getSession());
        $service->execute();
        return $this->redirect($this->Auth->logout());
    }

    // public function testEmail()
    // {
    //     $this->viewBuilder()->setLayout('CakeLte.login');
    //     $userName = $user->name ?? 'Usuário';

    //     $content = [
    //         'Você solicitou a troca de sua senha.',
    //         'Clique no botão abaixo para redefinir sua senha.',
    //         'Este link é válido por 1 dia. Após esse período, será necessário solicitar um novo link.'
    //     ];

    //     $url = 'https://example.com/fake-email-link';

    //     $this->set(compact('content', 'url', 'userName'));
    // }
}
