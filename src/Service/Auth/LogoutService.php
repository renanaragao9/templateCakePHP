<?php

namespace App\Service\Auth;

use App\Model\Table\SessionsTable;
use Cake\Http\Session;

class LogoutService
{
    protected $Sessions;
    protected $session;

    public function __construct(SessionsTable $Sessions, Session $session)
    {
        $this->Sessions = $Sessions;
        $this->session = $session;
    }

    public function execute(): void
    {
        $userId = $this->session->read('Auth.User.id');
        if ($userId) {
            $this->Sessions->deleteAll(['user_id' => $userId]);
        }
        $this->session->destroy();
    }
}
