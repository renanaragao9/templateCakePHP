<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Core\Configure;
use Authentication\Controller\Component\AuthenticationComponent;
use App\Utility\AccessChecker;
use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\Auth\DefaultPasswordHasher;
use TCPDF;

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
                        'name LIKE' => '%' . $search . '%',
                        'email LIKE' => '%' . $search . '%',
                    ],
                ];
            }
        }

        $query = $this->Users->find('all', [
            'conditions' => $conditions,
            'contain' => ['Roles'],
        ]);

        if ($this->request->is('get')) {
            $query = $this->applyFilters($query);
        }

        $users = $this->paginate($query);
        $fields = $this->getFields();
        $conditions = $this->getConditions();
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);

        $this->set(compact('users', 'roles', 'fields', 'conditions'));
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


    public function pdf(): void
    {
        $query = $this->Users->find('all');
        $query = $this->applyFilters($query);
        $users = $query->toArray();

        $systemName = Configure::read('App.name');

        $loggedInUser = $this->Auth->user('name');

        setlocale(LC_TIME, 'pt_BR.UTF-8');
        $dataAtual = strftime('%d de %B de %Y', strtotime('today'));

        $html = '<div style="text-align: center;">';
        $html .= '<img src="' . WWW_ROOT . 'img/logo/logo.png" alt="Logo" width="100" height="100">';
        $html .= '<h1>Relatório de Usuários</h1>';
        $html .= '</div>';
        $html .= '<div style="text-align: right;">';
        $html .= '<p>Fortaleza, ' . $dataAtual . '</p>';
        $html .= '</div>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
        $html .= '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Último Login</th><th>Contagem de Logins</th><th>Ativo</th><th>Criado</th><th>Modificado</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($users as $user) {
            $html .= '<tr>';
            $html .= '<td>' . h($user->id) . '</td>';
            $html .= '<td>' . h($user->name) . '</td>';
            $html .= '<td>' . h($user->email) . '</td>';
            $html .= '<td>' . ($user->last_login ? h($user->last_login->i18nFormat('dd/MM/yyyy')) : 'N/A') . '</td>';
            $html .= '<td>' . h($user->login_count) . '</td>';
            $html .= '<td>' . h($user->active) . '</td>';
            $html .= '<td>' . h($user->created->i18nFormat('dd/MM/yyyy')) . '</td>';
            $html .= '<td>' . h($user->modified->i18nFormat('dd/MM/yyyy')) . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $html .= '<div style="text-align: center; margin-top: 50px;">';
        $html .= '<p>__________________________</p>';
        $html .= '<p>' . $loggedInUser . '</p>';
        $html .= '<p>' . $systemName . '</p>';
        $html .= '</div>';

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Relatório de Usuários');
        $pdf->SetSubject('Relatório');
        $pdf->SetKeywords('TCPDF, PDF, relatório, usuários');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('relatorio_filtrado.pdf', 'I');
    }

    public function csv(): Response
    {
        $query = $this->Users->find('all');
        $query = $this->applyFilters($query);
        $users = $query->toArray();

        $csvContent = "ID,Nome,Email,Último Login,Contagem de Logins,Ativo,Criado,Modificado\n";
        foreach ($users as $user) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s\n",
                $user->id,
                $user->name,
                $user->email,
                $user->last_login ? $user->last_login->i18nFormat('dd/MM/yyyy') : 'N/A',
                $user->login_count,
                $user->active,
                $user->created->i18nFormat('dd/MM/yyyy'),
                $user->modified->i18nFormat('dd/MM/yyyy')
            );
        }

        $response = $this->response;
        $response = $response->withType('csv');
        $response = $response->withDownload('relatorio_filtrado.csv');
        $response = $response->withStringBody($csvContent);

        return $response;
    }

    private function getFields(): array
    {
        return [
            'id' => ['label' => 'ID', 'type' => 'text'],
            'name' => ['label' => 'Nome', 'type' => 'text'],
            'email' => ['label' => 'Email', 'type' => 'text'],
            'last_login' => ['label' => 'Último Login', 'type' => 'date'],
            'login_count' => ['label' => 'Contagem de Logins', 'type' => 'number'],
            'active' => ['label' => 'Ativo', 'type' => 'boolean'],
            'created' => ['label' => 'Criado', 'type' => 'date'],
            'modified' => ['label' => 'Modificado', 'type' => 'date'],
        ];
    }

    private function getConditions(): array
    {
        return [
            'LIKE' => 'Contém (mais preciso)',
            'BETWEEN' => 'Período',
            '=' => 'Igual',
            '!=' => 'Diferente',
            '>' => 'Maior',
            '<' => 'Menor',
            '>=' => 'Maior ou Igual',
            '<=' => 'Menor ou Igual',
        ];
    }

    private function applyFilters(Query $query): Query
    {
        $fields = $this->request->getQuery('fields');
        $conditions = $this->request->getQuery('conditions');
        $values = $this->request->getQuery('values');
        $values2 = $this->request->getQuery('values2');
        $queryConditions = [];

        if ($fields && $conditions && $values) {
            for ($i = 0; $i < count($fields); $i++) {
                if (!empty($fields[$i]) && !empty($conditions[$i]) && !empty($values[$i])) {
                    $field = $fields[$i];
                    $condition = $conditions[$i];
                    $value = (string)$values[$i];

                    if ($condition === 'BETWEEN') {
                        if (empty($values2[$i])) {
                            $this->Flash->error(__('O valor para o campo {0} deve ter dois valores para a condição "Entre".', $field));
                            return $this->redirect(['action' => 'index']);
                        }
                        $queryConditions["CAST($field AS CHAR) >="] = (string)$value;
                        $queryConditions["CAST($field AS CHAR) <="] = (string)$values2[$i];
                    } elseif ($condition === 'LIKE' || in_array($field, ['last_login', 'created', 'modified'])) {
                        $queryConditions["CAST($field AS CHAR) LIKE"] = '%' . $value . '%';
                    } else {
                        $queryConditions["CAST($field AS CHAR) $condition"] = $value;
                    }
                }
            }
        }

        try {
            return $query->where($queryConditions);
        } catch (\Exception $e) {
            $this->Flash->error(__('Ocorreu um erro ao aplicar os filtros: {0}', $e->getMessage()));
            return $this->redirect(['action' => 'index']);
        }
    }
}
