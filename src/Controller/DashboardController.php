<?php
declare (strict_types = 1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $dashboard = ['teste'];

        $this->set(compact('dashboard'));
    }
}
