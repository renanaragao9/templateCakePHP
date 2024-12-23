<!-- Adicione ícones aos links usando a classe .nav-icon
     com font-awesome ou qualquer outra biblioteca de ícones -->
<li class="nav-item has-treeview menu-open">
  <a href="#" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Páginas Iniciais
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="#" class="nav-link active">
        <i class="far fa-circle nav-icon"></i>
        <p>Página Ativa</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?=$this->Url->build(['controller' => 'AcademyConfig', 'action' => 'index'])?>" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Academy Config</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Página Inativa</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Link Simples
      <span class="right badge badge-danger">Novo</span>
    </p>
  </a>
</li>

<!-- Itens adicionais para eventos de academia -->
<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-dumbbell"></i>
    <p>
      Treinos
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Treino de Força</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Treino Cardio</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-calendar-alt"></i>
    <p>
      Eventos
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Competições</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Workshops</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-users"></i>
    <p>
      Comunidade
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Fóruns</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Grupos</p>
      </a>
    </li>
  </ul>
</li>
