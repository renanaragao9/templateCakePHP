<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use CakeLte\View\CakeLteTrait;
use Cake\View\View;

class AppView extends View
{
    use CakeLteTrait;

    public function initialize(): void
    {
        $this->initializeCakeLte();
    }
}
