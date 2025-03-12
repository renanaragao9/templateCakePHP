<?php

declare(strict_types=1);

namespace App\Controller;

use App\Utility\AccessChecker;
use Cake\Http\Response;

// Collaborators Seeder
//    ['name' => 'Collaborators/index', 'description' => 'Visualizar'],
//    ['name' => 'Collaborators/add', 'description' => 'Criar'],
//    ['name' => 'Collaborators/edit', 'description' => 'Editar'],
//    ['name' => 'Collaborators/delete', 'description' => 'Deletar'],

class CollaboratorsController extends AppController
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
        if (!$this->checkPermission('Collaborators/index')) {
            return;
        }

        $search = $this->request->getQuery('search');
        $conditions = [];

        if ($search) {
            if ($search) {
                $conditions = [
                    'OR' => [
                        'Collaborators.name LIKE' => '%' . $search . '%',
                    ],
                ];
            }
        }

        $query = $this->Collaborators->find('all', [
            'conditions' => $conditions,
            'contain' => ['Users'],
        ]);

        $collaborators = $this->paginate($query);

        $users = $this->Collaborators->Users->find('list', ['limit' => 200])->all();

        $this->set(compact('collaborators', 'users'));
    }

    public function view($id = null)
    {
        $collaborator = $this->Collaborators->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('collaborator'));
    }

    public function add(): ?Response
    {
        if (!$this->checkPermission('Collaborators/add')) {
            return $this->redirect(['action' => 'index']);
        }

        $collaborator = $this->Collaborators->newEmptyEntity();

        if ($this->request->is('post')) {

            $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());

            if ($this->Collaborators->save($collaborator)) {
                $this->Flash->success(__('O collaborator foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O collaborator não pode ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $users = $this->Collaborators->Users->find('list', ['limit' => 200])->all();

        $this->set(compact('collaborator', 'users'));
        return null;
    }

    public function edit(?int $id = null): ?Response
    {
        if (!$this->checkPermission('Collaborators/edit')) {
            return $this->redirect(['action' => 'index']);
        }

        $collaborator = $this->Collaborators->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $collaborator = $this->Collaborators->patchEntity($collaborator, $this->request->getData());

            if ($this->Collaborators->save($collaborator)) {
                $this->Flash->success(__('O collaborator foi editado com sucesso.'));
                $this->log('O collaborator foi editado com sucesso.', 'info');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('O collaborator não pode ser editado. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $users = $this->Collaborators->Users->find('list', ['limit' => 200])->all();

        $this->set(compact('collaborator', 'users'));
        return null;
    }

    public function delete(?int $id = null): Response
    {
        if (!$this->checkPermission('Collaborators/delete')) {
            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        $collaborator = $this->Collaborators->get($id);

        if ($this->Collaborators->delete($collaborator)) {
            $this->log('O collaborator foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O collaborator foi deletado com sucesso..'));
        } else {
            $this->Flash->error(__('O collaborator não pode ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
