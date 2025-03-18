<?php

declare(strict_types=1);

namespace App\Service\Users;

use Cake\ORM\Table;
use Cake\Http\Response;

class ExportService
{
    private Table $users;

    public function __construct(Table $users)
    {
        $this->users = $users;
    }

    public function run(): \Cake\Http\Response
    {
        $users = $this->users->find('all', [
            'contain' => ['Roles', 'Sessions'],
        ]);

        $csvData = [];
        $header = ['id', 'nome', 'email', 'último_login', 'contagem_login', 'ativo', 'perfil', 'criado', 'modificado'];
        $csvData[] = $header;

        foreach ($users as $user) {
            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->last_login,
                $user->login_count,
                $user->active ? 'Sim' : 'Não',
                $user->role->name,
                $user->created,
                $user->modified,
            ];
        }

        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = TMP . $filename;

        $file = fopen($filePath, 'w');
        foreach ($csvData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        $response = new Response();
        return $response->withFile(
            $filePath,
            ['download' => true, 'name' => $filename]
        );
    }
}
