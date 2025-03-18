<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Users\AddService;
use App\Service\Users\ViewService;
use App\Service\Users\EditService;
use App\Service\Users\DeleteService;
use App\Service\Users\ExportService;
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

        $service = new AddService($this->Users);

        if ($this->request->is('post')) {
            $result = $service->run($this->request->getData());

            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'index']);
        }

        $this->set('user', $service->getNewEntity());
        return null;
    }

    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('users/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new EditService($this->Users);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $service->run($id, $this->request->getData());

            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'index']);
        }

        $this->set($service->getEditData($id));
        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('users/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new DeleteService($this->Users);
        $result = $service->run($id);

        $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
        return $this->redirect(['action' => 'index']);
    }

    public function export(): Response
    {
        if (!$this->checkPermission('users/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new ExportService($this->Users);
        return $service->run();
    }
}
