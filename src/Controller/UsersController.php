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
        if (!$this->checkPermission('users/index')) {
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
        if (!$this->checkPermission('users/index')) {
            return;
        }

        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Sessions'],
        ]);

        $this->set(compact('user'));
    }

    public function add(): ?Response
    {
        if (!$this->checkPermission('users/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity(['contain' => ['Roles']]);

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            if (!empty($data['password'])) {
                $data['password'] = (new DefaultPasswordHasher())->hash($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O usuário não pode ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('user'));

        return null;
    }

    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('users/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            if ($data['email'] !== $user->email) {

                $existingUser = $this->Users->find('all', [
                    'conditions' => ['email' => $data['email']],
                ])->first();

                if ($existingUser) {
                    $this->Flash->error(__('O email fornecido já está em uso.'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = (new DefaultPasswordHasher())->hash($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi editado com sucesso.'));
                $this->log('O user foi editado com sucesso.', 'info');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O usuário não pode ser editado. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();

        $this->set(compact('user', 'roles'));

        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('users/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
            $this->log('O usuário foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O user foi deletado com sucesso..'));
        } else {
            $this->Flash->error(__('O user usuário pode ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export(): Response
    {
        if (!$this->checkPermission('users/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $users = $this->Users->find('all', [
            'contain' => ['Roles', 'Sessions'],
        ]);

        $csvData = [];
        $header = ['id', 'nome', 'email', 'último_login', 'contagem_login', 'ativo', 'perfil', 'criado', 'modificado'];
        $csvData[] = $header;

        foreach ($users as $user) {
            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->last_login,
                $user->login_count,
                $user->active ? 'Sim' : 'Não',
                $user->role->name,
                $user->created,
                $user->modified
            ];
        }

        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.csv';
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
