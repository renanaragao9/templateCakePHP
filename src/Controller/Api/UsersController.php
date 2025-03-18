<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\Auth\DefaultPasswordHasher;

class usersController extends AppController
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

        if (!empty($user->password)) {
            $user->password = (new DefaultPasswordHasher())->hash($user->password);
        }

        if ($this->Users->save($user)) {
            $response = [
                'status' => 'success',
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Não foi possível adicionar o usuário'
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function editUser($id): Response
    {
        $this->request->allowMethod(['PUT', 'patch']);
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->getData());

        if (!empty($user->password)) {
            $user->password = (new DefaultPasswordHasher())->hash($user->password);
        }

        if ($this->Users->save($user)) {
            $response = [
                'status' => 'success',
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Não foi possível atualizar o usuário'
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
                'message' => 'usuário excluído com sucesso'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Não foi possível excluir o usuário'
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }
}
