<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController
{
    private $identity;

    public function initialize(): void
    {
        parent::initialize();
        $this->identity = $this->request->getSession()->read('Auth.User.id');
    }

    private function checkPermission(string $permission): bool
    {
        if (!$this->identity || !AccessChecker::hasPermission($this->identity, $permission)) {
            $this->Flash->error('Você não tem permissão para acessar esta área.');
            $this->redirect('/');
            return false;
        }
        return true;
    }

    public function index(): void
    {
        if (!$this->checkPermission('Users/index')) {
            return;
        }

        $identity = $this->request->getSession()->read('Auth.User.id');
        if (!$identity || !AccessChecker::hasPermission($identity, 'Users/index')) {
            $this->Flash->error('Você não tem permissão para acessar esta área.');
            $this->redirect('/');
        }

        $search = $this->request->getQuery('search');
        $conditions = [];

        if ($search) {

            if ($search) {
                $conditions = [
                    'OR' => [
                        'Users.name LIKE' => '%' . $search . '%',
                        'Users.email LIKE' => '%' . $search . '%',
                    ],
                ];
            }
        }

        $query = $this->Users->find('all', [
            'conditions' => $conditions,
            'contain' => ['Roles'],
        ]);


        $users = $this->paginate($query);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);

        $this->set(compact('users', 'roles'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles'],
        ]);

        $this->set(compact('user'));
    }

    public function add(): ?Response
    {

        if (!$this->checkPermission('Users/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity(['contain' => ['Roles']]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($data['password'])) {
                $data['password'] = (new DefaultPasswordHasher())->hash($data['password']);
            }
            $data['last_login'] = null;
            $data['login_count'] = 0;

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O usuário não pôde ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('user'));
        return null;
    }

    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('Users/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => ['Roles'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi editado com sucesso.'));
                $this->log('O usuário foi editado com sucesso.', 'info');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O usuário não pôde ser editado. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('user'));
        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('Users/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $users = $this->Users->get($id);

        if ($this->Users->delete($users)) {
            $this->log('O usuário foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O usuário foi deletado com sucesso.'));
        } else {
            $this->Flash->error(__('O usuário não pôde ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
