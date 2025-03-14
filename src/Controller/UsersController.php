<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;

// Users Seeder
//    ['name' => 'Users/index', 'description' => 'Visualizar'],
//    ['name' => 'Users/add', 'description' => 'Criar'],
//    ['name' => 'Users/edit', 'description' => 'Editar'],
//    ['name' => 'Users/delete', 'description' => 'Deletar'],

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

        $search = $this->request->getQuery('search');
        $conditions = [];

        if ($search) {
            $conditions = [
                'OR' => [
                    'CAST(Users.id AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.name AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.email AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.password AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.last_login AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.login_count AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.active AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.role_id AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.created AS CHAR) LIKE' => '%' . $search . '%',
                    'CAST(Users.modified AS CHAR) LIKE' => '%' . $search . '%',
                ],
            ];
        }

        $query = $this->Users->find('all', [
            'conditions' => $conditions,
            'contain' => ['Roles', 'Sessions'],
        ]);

        $users = $this->paginate($query);

        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();

        $this->set(compact('users', 'roles'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Sessions'],
        ]);

        $this->set(compact('user'));
    }


    public function add(): ?Response
    {
        if (!$this->checkPermission('Users/add')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O user foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O user não pode ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();

        $this->set(compact('user', 'roles'));
        return null;
    }


    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('Users/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O user foi editado com sucesso.'));
                $this->log('O user foi editado com sucesso.', 'info');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O user não pode ser editado. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();

        $this->set(compact('user', 'roles'));
        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('Users/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->log('O user foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O user foi deletado com sucesso..'));
        } else {
            $this->Flash->error(__('O user não pode ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export(): Response
    {
        if (!$this->checkPermission('Users/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $users = $this->Users->find('all', [
            'contain' => ['Roles', 'Sessions'],
        ]);

        $csvData = [];
        $header = ['id', 'name', 'email', 'password', 'last_login', 'login_count', 'active', 'role_id', 'created', 'modified'];
        $csvData[] = $header;

        foreach ($users as $user) {
            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->password,
                $user->last_login,
                $user->login_count,
                $user->active,
                $user->role_id,
                $user->created,
                $user->modified
            ];
        }

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = TMP . $filename;

        $file = fopen($filePath, 'w');
        foreach ($csvData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        $response = $this->response->withFile(
            $filePath,
            ['download' => true, 'name' => $filename]
        );

        return $response;
    }
}
