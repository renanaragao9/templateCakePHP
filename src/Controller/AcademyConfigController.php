<?php

declare (strict_types = 1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;
use Laminas\Diactoros\UploadedFile;
use TCPDF;

class AcademyConfigController extends AppController
{
    public function index()
    {
        $search = $this->request->getQuery('search');
        $conditions = [];

        if ($search) {
            $conditions = [
                'OR' => [
                    'name LIKE' => '%' . $search . '%',
                ],
            ];
        }

        $query = $this->AcademyConfig->find('all', [
            'conditions' => $conditions,
        ]);

        $fields = $this->getFields();
        $conditions = $this->getConditions();

        $academyConfig = $this->paginate($query);
        $this->set(compact('academyConfig', 'fields', 'conditions'));
    }

    public function view($id = null)
    {
        $this->log('AcademyConfigController: view action called with id: ' . $id, 'info');
        $academyConfig = $this->AcademyConfig->get($id, [
            'contain' => [],
        ]);
        $this->set(compact('academyConfig'));
    }

    public function add()
    {
        $this->log('AcademyConfigController: add action called', 'info');
        $academyConfig = $this->AcademyConfig->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $this->log('AcademyConfigController: add action post data received', 'info');
            /** @var UploadedFile $file */
            $file = $data['logo_file'];
            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $this->log('AcademyConfigController: logo file uploaded', 'info');
                // Salvar a nova imagem
                $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                $uploadPath = WWW_ROOT . 'img' . DS . 'logo' . DS . $filename;
                $file->moveTo($uploadPath);
                $data['logo'] = $filename;
            }

            $academyConfig = $this->AcademyConfig->patchEntity($academyConfig, $data);
            if ($this->AcademyConfig->save($academyConfig)) {
                $this->log('AcademyConfigController: academy configuration saved successfully', 'info');
                $this->Flash->success(__('A configuração da academia foi salva.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->log('AcademyConfigController: failed to save academy configuration', 'error');
            $this->Flash->error(__('A configuração da academia não pôde ser salva. Por favor, tente novamente.'));
        }
        $this->set(compact('academyConfig'));
    }

    public function edit($id = null)
    {
        $this->log('AcademyConfigController: edit action called with id: ' . $id, 'info');
        $academyConfig = $this->AcademyConfig->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $this->log('AcademyConfigController: edit action post data received', 'info');
            /** @var UploadedFile $file */
            $file = $data['logo_file'];
            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $this->log('AcademyConfigController: logo file uploaded', 'info');
                // Excluir a imagem antiga
                $oldLogoPath = WWW_ROOT . 'img' . DS . 'logo' . DS . $academyConfig->logo;
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }

                // Salvar a nova imagem
                $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                $uploadPath = WWW_ROOT . 'img' . DS . 'logo' . DS . $filename;
                $file->moveTo($uploadPath);
                $data['logo'] = $filename;
            }

            $academyConfig = $this->AcademyConfig->patchEntity($academyConfig, $data);
            if ($this->AcademyConfig->save($academyConfig)) {
                $this->log('AcademyConfigController: academy configuration updated successfully', 'info');
                $this->Flash->success(__('A configuração da academia foi salva.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->log('AcademyConfigController: failed to update academy configuration', 'error');
            $this->Flash->error(__('A configuração da academia não pôde ser salva. Por favor, tente novamente.'));
        }
        $this->set(compact('academyConfig'));
    }

    public function delete($id = null)
    {
        $this->log('AcademyConfigController: delete action called with id: ' . $id, 'info');
        $this->request->allowMethod(['post', 'delete']);
        $academyConfig = $this->AcademyConfig->get($id);
        if ($academyConfig->logo) {
            $logoPath = WWW_ROOT . 'img' . DS . 'logo' . DS . $academyConfig->logo;
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }
        if ($this->AcademyConfig->delete($academyConfig)) {
            $this->log('AcademyConfigController: academy configuration deleted successfully', 'info');
            $this->Flash->success(__('A configuração da academia foi excluída.'));
        } else {
            $this->log('AcademyConfigController: failed to delete academy configuration', 'error');
            $this->Flash->error(__('A configuração da academia não pôde ser excluída. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleDarkMode()
    {
        $this->log('AcademyConfigController: toggleDarkMode action called', 'info');
        if (!$this->request->is('post')) {
            throw new BadRequestException();
        }

        $session = $this->request->getSession();
        $darkMode = $session->read('dark-mode', false);
        $session->write('dark-mode', !$darkMode);

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true]));
    }

    public function gerarPdf()
    {
        $fields = $this->request->getQuery('fields'); // Obtém os campos da query string
        $conditions = $this->request->getQuery('conditions'); // Obtém as condições da query string
        $values = $this->request->getQuery('values'); // Obtém os valores da query string
        $values2 = $this->request->getQuery('values2'); // Obtém os valores adicionais da query string (usado para condições BETWEEN)
        $queryConditions = []; // Inicializa o array de condições da query

        if ($fields && $conditions && $values) {
            for ($i = 0; $i < count($fields); $i++) {
                if (!empty($fields[$i]) && !empty($conditions[$i]) && !empty($values[$i])) {
                    $field = $fields[$i]; // Campo atual
                    $condition = $conditions[$i]; // Condição atual
                    $value = $values[$i]; // Valor atual

                    if ($condition === 'BETWEEN') {
                        if (empty($values2[$i])) {
                            $this->Flash->error(__('O valor para o campo {0} deve ter dois valores para a condição "Entre".', $field));
                            return $this->redirect(['action' => 'index']);
                        }
                        $queryConditions["$field >="] = $value; // Condição "maior ou igual a"
                        $queryConditions["$field <="] = $values2[$i]; // Condição "menor ou igual a"
                    } elseif ($condition === 'LIKE' || in_array($field, ['last_login', 'created', 'modified'])) {
                        $queryConditions["$field LIKE"] = '%' . $value . '%'; // Condição "LIKE" para campos de texto ou datas
                    } else {
                        $queryConditions["$field $condition"] = $value; // Outras condições (e.g., '=', '!=', '>', '<', etc.)
                    }
                }
            }
        }

        $academyConfigs = $this->AcademyConfig->find('all', [
            'conditions' => $queryConditions, // Aplica as condições da query
        ])->toArray();

        if ($academyConfigs == null) {
            $this->Flash->warning(__('Filtragem inválida ou sem registro.'));
            return $this->redirect(['action' => 'index']);
        }

        // Obter o nome do sistema dinamicamente
        $systemName = 'Nome do Sistema';

        // Obter o nome do usuário logado
        $loggedInUser = $this->Auth->user('name');

        // Traduzir o mês para português
        setlocale(LC_TIME, 'pt_BR.UTF-8');
        $dataAtual = strftime('%d de %B de %Y', strtotime('today'));

        // Gerar o conteúdo HTML para o PDF
        $html = '<div style="text-align: center;">';
        $html .= '<img src="' . WWW_ROOT . 'img/logo/logo.png" alt="Logo" width="100" height="100">';
        $html .= '<h1>Relatório de Usuários</h1>';
        $html .= '</div>';
        $html .= '<div style="text-align: right;">';
        $html .= '<p>Fortaleza, ' . $dataAtual . '</p>';
        $html .= '</div>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
        $html .= '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Data de Criação</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($academyConfigs as $academyConfig) {
            $html .= '<tr>';
            $html .= '<td>' . h($academyConfig->id) . '</td>';
            $html .= '<td>' . h($academyConfig->name) . '</td>';
            $html .= '<td>' . h($academyConfig->logo) . '</td>';
            $html .= '<td>' . h($academyConfig->created ? $academyConfig->created->format('d/m/Y H:i:s') : '') . '</td>';
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

    private function getFields()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'logo' => 'logo',
            'created' => 'Criado',
            'modified' => 'Modificado',
        ];
    }

    private function getConditions()
    {
        return [
            '=' => 'Igual',
            '!=' => 'Diferente',
            '>' => 'Maior',
            '<' => 'Menor',
            '>=' => 'Maior ou Igual',
            '<=' => 'Menor ou Igual',
            'LIKE' => 'Contém (mais preciso)',
            'BETWEEN' => 'Período',
        ];
    }
}
