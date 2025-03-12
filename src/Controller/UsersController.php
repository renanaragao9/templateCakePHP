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
        if ($search) {
            $conditions = [
                'OR' => [
                    'Users.name LIKE' => '%' . $search . '%',
                ],
            ];
        }
    }

    $query = $this->Users->find('all', [
        'conditions' => $conditions,
        'contain' => ['Roles', 'Collaborators'],
    ]);

    $users = $this->paginate($query);

                        $roles = $this->Users->Roles->find('list', ['limit' => 200])->all();
    
    $this->set(compact('users', 'roles'));
}

public function view($id = null)
{
    $user = $this->Users->get($id, [
        'contain' => ['Roles', 'Collaborators'],
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
        }
        else {
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

}