<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;

/*
    # Permissoes de acesso UsersController
    # Copie o conteudo e cole no arquivo de permissoes de acesso
    # Arquivo de permissoes de acesso: config/Seeds/PermissionsSeed.php

    #***** ATENÇÃO *****#
    # Caso já tenha o sistema em produção, vá no sistema em Cadastros -> Perfis -> Administrador -> View e adicione as permissões manualmente
*/

/*
    #Users Seeder
    ['name' => 'users/index', 'description' => 'Visualizar', 'group' => 'Users'],
    ['name' => 'users/add', 'description' => 'Criar', 'group' => 'Users'],
    ['name' => 'users/edit', 'description' => 'Editar', 'group' => 'Users'],
    ['name' => 'users/delete', 'description' => 'Deletar', 'group' => 'Users'],
*/

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

    /*
        # Controller API Template
        # Path: src/Controllers/API/UsersController.php
        # Copie e cole o conteúdo abaixo no arquivo acima
        # Lembre-se de alterar os valores das variáveis de acordo com o seu projeto
        # Não esqueça de adicionar as rotas no arquivo src/Config/routes.php
        # Para acessar a API, utilize a URL: http://localhost:8765/api/users
    */

    /*
        <?php

        namespace App\Controller\Api;

        use App\Controller\AppController;
        use Cake\Http\Response;

        class UsersController extends AppController
        {
            public function fetchUsers(): Response
            {
                $this->request->allowMethod(['get']);

                try {
                    $data = $this->Users->find('all')->toArray();
                    $response = [
                        'status' => 'success',
                        'data' => $data
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                }
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }

            public function fetchUser($id): Response
            {
                $this->request->allowMethod(['get']);

                try {
                    $data = $this->Users->get($id);
                    $response = [
                        'status' => 'success',
                        'data' => $data
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                }
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }

            public function addUser(): Response
            {
                $this->request->allowMethod(['post']);

                $user = $this->Users->newEmptyEntity();
                $user = $this->Users->patchEntity($user, $this->request->getData());

                if ($this->Users->save($user)) {
                    $response = [
                        'status' => 'success',
                        'data' => $user
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Unable to add user'
                    ];
                }

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }

            public function editUser($id): Response
            {
                $this->request->allowMethod(['put', 'patch']);

                $user = $this->Users->get($id);
                $user = $this->Users->patchEntity($user, $this->request->getData());

                if ($this->Users->save($user)) {
                    $response = [
                        'status' => 'success',
                        'data' => $user
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Unable to update user'
                    ];
                }

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }

            public function deleteUser($id): Response
            {
                $this->request->allowMethod(['delete']);

                $user = $this->Users->get($id);

                if ($this->Users->delete($user)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'user deleted successfully'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Unable to delete user'
                    ];
                }

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }
        }
    */

    /*
        # Rotas API Template
        # Path: src/Config/routes.php
        # Copie e cole o conteúdo abaixo no arquivo acima
        # Lembre-se de alterar os valores das variáveis de acordo com o seu projeto
    */

    /*
        # users routes template prefix API   

        # users routes API
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'fetchUsers', 'method' => 'GET']);
        $routes->connect('/user/:id', ['controller' => 'Users', 'action' => 'fetchUser', 'method' => 'GET'], ['pass' => ['id'], 'id' => '\d+']);
        $routes->connect('/user-add', ['controller' => 'Users', 'action' => 'addUser', 'method' => 'POST']);
        $routes->connect('/user-edit/:id', ['controller' => 'Users', 'action' => 'editUser', 'method' => ['PUT', 'PATCH']], ['pass' => ['id'], 'id' => '\d+']);
        $routes->connect('/user-delete/:id', ['controller' => 'Users', 'action' => 'deleteUser', 'method' => 'DELETE'], ['pass' => ['id'], 'id' => '\d+']);
    */

    /*
        # users routes simple template prefix /
        
        # users routes
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $routes->connect('/user/view/:id', ['controller' => 'Users', 'action' => 'view'], ['pass' => ['id'], 'id' => '\d+']);
    */
}
