<!-- Adicione ícones aos links usando a classe .nav-icon
com font-awesome ou qualquer outra biblioteca de ícones -->
<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');
?>

<li class="nav-item">
  <a href="/" class="nav-link <?= $this->request->getPath() === '/' ? 'active' : '' ?>">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>

<?php if (
  AccessChecker::hasPermission($loggedUserId, 'Roles/index') ||
  AccessChecker::hasPermission($loggedUserId, 'Users/index')
): ?>
  <li class="nav-item has-treeview <?= (
                                      $this->request->getParam('controller') === 'Roles' ||
                                      $this->request->getParam('controller') === 'Users'
                                      ? 'menu-open' : '')
                                      ? 'menu-open' : ''
                                    ?>">
    <a href="#" class="nav-link <?=
                                $this->request->getParam('controller') === 'Roles' ||
                                  $this->request->getParam('controller') === 'Users'
                                  ? 'active' : ''
                                ?>">
      <i class="nav-icon fas fa-edit"></i>
      <p>
        Cadastro
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <?php if (AccessChecker::hasPermission($loggedUserId, 'Users/index')): ?>
        <li class="nav-item">
          <?= $this->Html->link(
            '<i class="far fa-circle nav-icon"></i><p>Usuários</p>',
            ['controller' => 'Users', 'action' => 'index'],
            ['class' => 'nav-link ' . ($this->request->getParam('controller') === 'Users' ? 'active' : ''), 'escape' => false]
          ) ?>
        </li>
      <?php endif; ?>
      <?php if (AccessChecker::hasPermission($loggedUserId, 'Roles/index')): ?>
        <li class="nav-item">
          <?= $this->Html->link(
            '<i class="far fa-circle nav-icon"></i><p>Perfis</p>',
            ['controller' => 'Roles', 'action' => 'index'],
            ['class' => 'nav-link ' . ($this->request->getParam('controller') === 'Roles' ? 'active' : ''), 'escape' => false]
          ) ?>
        </li>
      <?php endif; ?>
    </ul>
  </li>
<?php endif; ?>