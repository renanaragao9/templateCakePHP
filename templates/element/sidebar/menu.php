<!-- Adicione ícones aos links usando a classe .nav-icon
com font-awesome ou qualquer outra biblioteca de ícones -->
<?php

use App\Utility\AccessChecker;

$loggedUserId = $this->request->getSession()->read('Auth.User.id');

function hasPermission($userId, $permission)
{
  return AccessChecker::hasPermission($userId, $permission);
}

function generateNavItem($controller, $action, $iconClass, $label, $request, $htmlHelper)
{
  return $htmlHelper->link(
    "<i class=\"$iconClass nav-icon\"></i><p>$label</p>",
    ['controller' => $controller, 'action' => $action],
    ['class' => 'nav-link ' . ($request->getParam('controller') === $controller ? 'active' : ''), 'escape' => false]
  );
}
?>

<li class="nav-item">
  <a href="/" class="nav-link <?= $this->request->getPath() === '/' ? 'active' : '' ?>">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>

<?php if (hasPermission($loggedUserId, 'Roles/index') || hasPermission($loggedUserId, 'Users/index')): ?>
  <li class="nav-item has-treeview <?= ($this->request->getParam('controller') === 'Roles' || $this->request->getParam('controller') === 'Users' ? 'menu-open' : '') ?>">
    <a href="#" class="nav-link <?= $this->request->getParam('controller') === 'Roles' || $this->request->getParam('controller') === 'Users' ? 'active' : '' ?>">
      <i class="nav-icon fas fa-edit"></i>
      <p>
        Cadastro
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <?php if (hasPermission($loggedUserId, 'Users/index')): ?>
        <li class="nav-item">
          <?= generateNavItem('Users', 'index', 'fa-light fa-circle-notch', 'Usuários', $this->request, $this->Html) ?>
        </li>
      <?php endif; ?>

      <?php if (hasPermission($loggedUserId, 'Roles/index')): ?>
        <li class="nav-item">
          <?= generateNavItem('Roles', 'index', 'fa-light fa-circle-notch', 'Perfis', $this->request, $this->Html) ?>
        </li>
      <?php endif; ?>
    </ul>
  </li>
<?php endif; ?>