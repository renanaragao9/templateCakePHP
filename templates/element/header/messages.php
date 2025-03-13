<li class="nav-item dropdown">
  <a class="nav-link" id="nav-icon" data-toggle="dropdown" href="#">
    <i class="fa-regular fa-inbox"></i>
    <span class="badge badge-danger navbar-badge">3</span>
  </a>
  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <a href="#" class="dropdown-item">
      <!-- Início da Mensagem -->
      <div class="media">
        <?= $this->Html->image('CakeLte./AdminLTE/dist/img/user1-128x128.jpg', ['class' => 'img-size-50 img-circle mr-3', 'alt' => 'Avatar do Usuário']) ?>
        <div class="media-body">
          <h3 class="dropdown-item-title">
            Brad Diesel
            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
          </h3>
          <p class="text-sm">Me ligue quando puder...</p>
          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas Atrás</p>
        </div>
      </div>
      <!-- Fim da Mensagem -->
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
      <!-- Início da Mensagem -->
      <div class="media">
        <?= $this->Html->image('CakeLte./AdminLTE/dist/img/user8-128x128.jpg', ['class' => 'img-size-50 img-circle mr-3', 'alt' => 'Avatar do Usuário']) ?>
        <div class="media-body">
          <h3 class="dropdown-item-title">
            John Pierce
            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
          </h3>
          <p class="text-sm">Recebi sua mensagem, mano</p>
          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas Atrás</p>
        </div>
      </div>
      <!-- Fim da Mensagem -->
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
      <!-- Início da Mensagem -->
      <div class="media">
        <?= $this->Html->image('CakeLte./AdminLTE/dist/img/user3-128x128.jpg', ['class' => 'img-size-50 img-circle mr-3', 'alt' => 'Avatar do Usuário']) ?>
        <div class="media-body">
          <h3 class="dropdown-item-title">
            Nora Silvester
            <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
          </h3>
          <p class="text-sm">O assunto vai aqui</p>
          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Horas Atrás</p>
        </div>
      </div>
      <!-- Fim da Mensagem -->
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item dropdown-footer">Ver Todas as Mensagens</a>
  </div>
</li>