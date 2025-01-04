<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;

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

            if ($search) {
                $conditions = [
                    'OR' => [
                        'name LIKE' => '%' . $search . '%',
                    ],
                ];
            }
        }

        $query = $this->Roles->find('all', [
            'conditions' => $conditions,
        ]);


        $query = $query->contain(['RolesPermissions']);
        $roles = $this->paginate($query);

        $permissions = $this->Roles->Permissions->find()
            ->all()
            ->groupBy('group');

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

        $role = $this->Roles->newEmptyEntity();

        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $permissions = $this->request->getData('permissions');
                if (!empty($permissions)) {
                    foreach ($permissions as $permissionId) {
                        $rolePermission = $this->Roles->RolesPermissions->newEmptyEntity();
                        $rolePermission->role_id = $role->id;
                        $rolePermission->permission_id = (int)$permissionId;
                        $this->Roles->RolesPermissions->save($rolePermission);
                    }
                }
                $this->Flash->success(__('O perfil foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O perfil não pôde ser salvo. Por favor, tente novamente.'));
            }
        }

        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200])->all();
        $this->set(compact('role', 'permissions'));
        return null;
    }


    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('Roles/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $role = $this->Roles->get($id, [
            'contain' => ['Permissions'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());

            if ($this->Roles->save($role)) {

                $this->Roles->RolesPermissions->deleteAll(['role_id' => $role->id]);

                $permissions = $this->request->getData('permissions');
                if (!empty($permissions)) {
                    foreach ($permissions as $permissionId) {
                        $rolePermission = $this->Roles->RolesPermissions->newEmptyEntity();
                        $rolePermission->role_id = $role->id;
                        $rolePermission->permission_id = (int)$permissionId;
                        $this->Roles->RolesPermissions->save($rolePermission);
                    }
                }

                $this->Flash->success(__('O perfil foi editado com sucesso.'));
                $this->log('O perfil foi editado com sucesso.', 'info');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O perfil não pôde ser editado. Por favor, tente novamente.'));
            }
        }

        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200])->all();
        $this->set(compact('role', 'permissions'));
        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('Roles/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        if ($id === 1) {
            $this->Flash->warning(__('O perfil de administrador não pode ser apagado.'));
            return $this->redirect(['action' => 'index']);
        }

        $role = $this->Roles->get($id);

        if ($this->Roles->delete($role)) {
            $this->Roles->RolesPermissions->deleteAll(['role_id' => $role->id]);
            $this->log('O role foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O perfil foi deletado com sucesso.'));
        } else {
            $this->Flash->error(__('O perfil não pôde ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
