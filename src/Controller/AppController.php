<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('CakeLte.default');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ],
                ],
            ],
            'loginAction' => [
                'controller' => 'Auth',
                'action' => 'login',
            ],
            'logoutRedirect' => [
                'controller' => 'Auth',
                'action' => 'login',
            ],
            'authError' => 'Você não está autorizado a acessar essa área.',
            'storage' => 'Session',
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        $this->Auth->allow(['display']);
    }
}
