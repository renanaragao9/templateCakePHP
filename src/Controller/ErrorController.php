<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Framework de Desenvolvimento Rápido (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licenciado sob a Licença MIT
 * Para obter informações completas sobre direitos autorais e licença, consulte o LICENSE.txt
 * Redistribuições de arquivos devem manter o aviso de direitos autorais acima.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org Projeto CakePHP(tm)
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php Licença MIT
 */

namespace App\Controller;

use Cake\Event\EventInterface;

class ErrorController extends AppController
{
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(EventInterface $event) {}

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');
    }
    public function afterFilter(EventInterface $event) {}
}
