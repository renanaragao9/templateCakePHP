<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Http\Response;
use Cake\ORM\Query;
use TCPDF;

class UsersController extends AppController
{

public function index(): void
{
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
    ]);

    if ($this->request->is('get')) {
        $query = $this->applyFilters($query);
    }

    $users = $this->paginate($query);
    $fields = $this->getFields();
    $conditions = $this->getConditions();

    $this->set(compact('users', 'fields', 'conditions'));
}

public function view($id = null)
{
    $user = $this->Users->get($id, [
        'contain' => ['AcademyConfig'],
    ]);

    $this->set(compact('user'));
}


public function add(): ?Response
{
    $user = $this->Users->newEmptyEntity();
    
    if ($this->request->is('post')) {
        
        $user = $this->Users->patchEntity($user, $this->request->getData());
        
        if ($this->Users->save($user)) {
            $this->Flash->success(__('O user foi salvo com sucesso.'));
            return $this->redirect(['action' => 'index']);
        }
        else {
            $this->Flash->error(__('O user não pôde ser salvo. Por favor, tente novamente.'));            
            return $this->redirect(['action' => 'index']);
        }
    }
    
    $this->set(compact('user'));
    return null;
}


public function edit(?int $id = null): ?Response
{
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
            $this->Flash->error(__('O user não pôde ser editado. Por favor, tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    $this->set(compact('user'));
    return null;
}

    public function delete(?int $id = null): Response
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $user = $this->Users->get($id);
        
        if ($this->Users->delete($user)) {
            $this->log('O user foi deletado com sucesso.', 'info');
            $this->Flash->success(__('O user foi deletado com sucesso..'));
        } else {
            $this->Flash->error(__('O user não pôde ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     public function pdf(): void
    {
        $query = $this->Users->find('all');
        $query = $this->applyFilters($query);
        $users = $query->toArray();

        $systemName = 'Nome do Sistema';

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
        $html .= '<thead><tr><th>ID</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($users as $user) {
            $html .= '<tr>';
            $html .= '<td>' . h($user->id) . '</td>';
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
        $pdf->SetAuthor('Seu Nome');
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

        $csvContent = "ID\n";
        foreach ($users as $user) {
            $csvContent .= sprintf(
                "%s\n",
                $user->id,
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