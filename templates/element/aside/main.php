<div class="p-3">
  <h5>Título</h5>
  <p>Conteúdo da barra lateral</p>

  <hr>

  <p>
    <?=$this->Html->link(
    __('<i class="fab fa-github fa-fw"></i> {0} {1}', 'CakeLte', CAKELTE_VERSION),
    'https://github.com/arodu/cakelte',
    ['escape' => false, 'target' => '_blank']
)?>
  </p>

</div>