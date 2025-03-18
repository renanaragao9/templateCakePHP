<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;
use App\Service\Roles\AddService;
use App\Service\Roles\EditService;
use App\Service\Roles\DeleteService;

class RolesController extends AppController
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
        if (!$this->checkPermission('Roles/index')) {
            return;
        }

        $search = $this->request->getQuery('search');
        $conditions = [];

        if ($search) {
            $conditions = [
                'OR' => [
                    'name LIKE' => '%' . $search . '%',
                ],
            ];
        }

        $query = $this->Roles->find('all', [
            'conditions' => $conditions,
        ]);

        $query = $query->contain(['RolesPermissions']);
        $roles = $this->paginate($query);

        $permissions = $this->Roles->Permissions->find()
            ->all()
            ->groupBy(function ($permission) {
                return $permission->group ?? 'default';
            });

        $this->set(compact('roles', 'permissions'));
    }

    public function view($id = null)
    {
        if (!$this->checkPermission('Roles/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $role = $this->Roles->get($id, [
            'contain' => ['Permissions', 'Users'],
        ]);

        $this->set(compact('role'));
    }

    public function add(): ?Response
    {
        if (!$this->checkPermission('Roles/index')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new AddService($this->Roles);

        if ($this->request->is('post')) {
            $result = $service->run($this->request->getData());
            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'index']);
        }

        $role = $service->getNewEntity();
        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200])->all();

        $this->set(compact('role', 'permissions'));
        return null;
    }

    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('Roles/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new EditService($this->Roles);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $service->run($id, $this->request->getData());
            $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
            return $this->redirect(['action' => 'index']);
        }

        $data = $service->getEditData($id);
        $this->set($data);
        return null;
    }


    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('Roles/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $service = new DeleteService($this->Roles);
        $result = $service->run($id);

        $this->Flash->{$result['success'] ? 'success' : 'error'}($result['message']);
        return $this->redirect(['action' => 'index']);
    }
}
