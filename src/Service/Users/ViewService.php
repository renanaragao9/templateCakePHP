<?php

declare(strict_types=1);

namespace App\Service\Users;

use Cake\ORM\Table;

class ViewService
{
    private Table $users;

    public function __construct(Table $users)
    {
        $this->users = $users;
    }

    public function run(int $id): array
    {
        $user = $this->users->get($id, [
            'contain' => ['Roles', 'Sessions'],
        ]);

        return compact('user');
    }
}
